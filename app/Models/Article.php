<?php

namespace App\Models;

use App\AppConf;
use App\Application;
use App\Repositories\Base\FileRepository;
use App\Repositories\Base\StringClearRepository;
use App\Repositories\Base\StringRepository;
use App\Repositories\BaseRepository;
use App\Repositories\Wiki\WikiArticleRepository;
use Ehann\RediSearch\Fields\NumericField;
use Ehann\RediSearch\Fields\TextField;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Scout\Searchable;

/**
 * Class Article
 *
 * @property int $id
 * @property int $parent_article_id
 * @property int $wiki_id
 * @property string $title
 * @property string $slug
 * @property object $seo_intros
 * @property object $seo_intro_keywords
 * @property string $intro
 * @property object $image
 * @property int $weight
 * @property int $status_id
 * @property \Carbon\Carbon $created_at
 *
 * @property \App\Models\DataArticle $tags
 * @property \App\Models\Tag $tag
 * @property \App\Models\DataArticle $data_article
 * @property \Illuminate\Database\Eloquent\Collection $children_articles
 * @property \Illuminate\Database\Eloquent\Collection $category_children_articles
 * @property \Illuminate\Database\Eloquent\Collection $public_children_articles
 * @property \Illuminate\Database\Eloquent\Collection $all_public_children_articles
 * @property \Illuminate\Database\Eloquent\Collection $limited_children_articles
 * @property \App\Models\Article $parent_article
 * @property \App\Models\Article $children_article
 * @property \App\Models\WikiSearchResult $wiki_search_result
 *
 * @package App\Models
 */
class Article extends ModelBase
{
    use Searchable;
    //public $asYouType = true;

    public function searchableAs()
    {
        return "article_index";
    }

    public function toSearchableArray()
    {
        return [
            //'id' => $this->id,
            'title' => $this->title,
            'status_id' => $this->status_id,
        ];
    }
    public function searchableSchema()
    {
        return [
            "title" => TextField::class,
            "status_id" => TextField::class,
        ];
    }

    const STATUS_PUBLIC = 1;
    const STATUS_CATEGORY = 2;
    const STATUS_LIMITED = 6;
    const STATUS_HIDDEN = 11;
    const STATUS_ERROR = 21;

    const IMAGE_PATHS = ['small/', 'big/', 'icon/'];
    const IMAGE_WIDTH = 320;
    const IMAGE_WIDTHS = [320, 640, 48];
    const IMAGE_HEIGHTS = [null, null, 32];

    const HOME_ID = 1;
    const MAX_PAGE_COUNT = 10000;

    const EMPTY_SLUG = 'article.html';

    //-----------------------------------------------

    protected $table = 'articles';
    protected $connection = AppConf::BASE_MYSQL_CONNECTION;
    public $timestamps = false;

    static $notParseObjectData = false;
    static $ignoreBootDeletingChildren = false;

    protected $casts = [
        'id' => 'int',
        'parent_article_id' => 'int',
        'wiki_id' => 'int',
        'weight' => 'int',
        'status_id' => 'int',
    ];

    protected $attributes = [
        'weight' => 65534,
        'status_id' => Article::STATUS_PUBLIC,
        'seo_intros' => '[]',
        'seo_intro_keywords' => '[]',
    ];

    protected $fillable = [
        'id',
        'parent_article_id',
        'wiki_id',
        'title',
        'slug',
        'intro',
        'seo_intros',
        'seo_intro_keywords',
        'image',
        'weight',
        'status_id',
        'created_at',
    ];

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('orderByWeight', function (Builder $builder) {
            $builder->orderBy('weight')->orderBy('id');
        });

        static::creating(function(self $model)  {
            $model->slug = !empty($model->slug) ? $model->slug : Article::getSlug($model->title);
        });
        static::created(function(self $model)  {
            DataArticle::create(['id' => $model->id]);
        });

        static::updating(function(self $model)  {
            if(!empty($model->title) && $model->id != Article::HOME_ID){
                $model->slug = Article::getSlug($model->title);
            }
        });

        static::deleting(function(self $model) {
            if($model->children_articles->isNotEmpty()){
                foreach ($model->children_articles as $childrenArticle){
                    $childrenArticle->delete();
                }
            }

            if(!empty($model->image)){
                if(!Article::where('image', 'like', $model->image->name.'||'.$model->height)->where('id', '!=', $model->id)->first()){
                    foreach (Article::IMAGE_PATHS as $imagePath){
                        FileRepository::fileDelete($model->image->name, $imagePath);
                    }
                }
            }
        });
    }

    //-------------------------------

    public function data_article()
    {
        return $this->hasOne(DataArticle::class, 'id', 'id');
    }

    public function category_children_articles()
    {
        return $this->hasMany(Article::class, 'parent_article_id')->where('status_id', Article::STATUS_CATEGORY);
    }

    public function public_children_articles()
    {
        return $this->hasMany(Article::class, 'parent_article_id')->where('status_id', Article::STATUS_PUBLIC);
    }

    public function all_public_children_articles()
    {
        return $this->hasMany(Article::class, 'parent_article_id')->where('status_id', Article::STATUS_PUBLIC);
    }

    public function limited_children_articles()
    {
        return $this->hasMany(Article::class, 'parent_article_id')->where('status_id', Article::STATUS_LIMITED);
    }

    public function children_articles()
    {
        return $this->hasMany(Article::class, 'parent_article_id');
    }

    public function children_article()
    {
        return $this->hasOne(Article::class, 'parent_article_id');
    }

    public function parent_article()
    {
        return $this->belongsTo(Article::class, 'parent_article_id');
    }

    public function wiki_search_result()
    {
        return $this->belongsTo(WikiSearchResult::class, 'wiki_id', 'wiki_id');
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function tag()
    {
        return $this->hasOne(Tag::class);
    }

    //-------------------------------

    /*public function getTitleAttribute($value)
    {
        return !empty($value) ? $value : $this->data_article->wiki_title;
    }*/

    public function getSeoIntroKeywordsAttribute($value)
    {
        if(self::$notParseObjectData){
            return $value;
        }
        $value = !empty($value) ? json_decode($value) : [];
        return !empty($value) ? $value : [];
    }

    public function setSeoIntroKeywordsAttribute($value)
    {
        $this->attributes['seo_intro_keywords'] = is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : '[]';
    }

    public function getSeoIntrosAttribute($value)
    {
        if(self::$notParseObjectData){
            return $value;
        }
        $value = !empty($value) ? json_decode($value) : [];
        return !empty($value) ? $value : [];
    }

    public function setSeoIntrosAttribute($value)
    {
        $this->attributes['seo_intros'] = is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : '[]';
    }

    public function getImageAttribute($value)
    {
        if(!empty($value)){
            $value = explode('||', $value);
            if(is_array($value) && count($value) == 2){
                return (object)[
                    'name' => $value[0],
                    'height' => $value[1],
                ];
            }
        }
        return null;
    }

    public function setImageAttribute($value)
    {
        if(is_object($value) && !empty($value->url) && empty($value->name)){
            $value->name = FileRepository::getFileNameFromUrl($value->url);
        }
        $this->attributes['image'] = is_object($value) ? $value->name.'||'.$value->height : (mb_substr_count($value, '||') == 1 ? $value : null);
    }

    //-------------------------------

    static function getSlug($title = null)
    {
        return BaseRepository::slug((!empty($title) ? $title : ''), Article::EMPTY_SLUG, '.html');
    }

    static function createCustomArticle($title, $parent_article_id)
    {
        if($model = Article::where('title', $title)->where('parent_article_id', $parent_article_id)->first()){
            return $model;
        }

        $wikiId = Article::where('wiki_id', '<', 0)->min('wiki_id');
        if($model = Article::create([
            'parent_article_id' => $parent_article_id,
            'wiki_id' => !empty($wikiId) ? $wikiId - 1 : -1,
            'title' => $title,
        ])){
            DataArticle::where('id', $model->id)->update([
                'origin_title' => $title
            ]);

            return $model;
        }

        return false;
    }

    static function checkStatus($article, $dataArticle, $articleStatusId = null)
    {
        $articleStatusId = !empty($articleStatusId) ? $articleStatusId : $article->status_id;

        if($dataArticle->categorymembers_status_id == DataArticle::CATEGORYMEMBERS_STATUS_CATEGORY || $article->title == AppConf::EMPTY_ARTICLE_TITLES[0] || $dataArticle->origin_title == AppConf::EMPTY_ARTICLE_TITLES[0]){
            $articleStatusId = Article::STATUS_CATEGORY;
            if(empty($article->children_article)){
                $articleStatusId = Article::STATUS_HIDDEN;
            }
        }else if(empty($article->children_article)){
            $contents = $dataArticle->contents;
            if(!WikiArticleRepository::validationContent($contents)){
                if(empty($article->images) && StringRepository::getOnlyCharsLen($article->intro) < 100){
                    $articleStatusId = Article::STATUS_HIDDEN;
                }else if(!WikiArticleRepository::validationContent($article->intro, 500)){
                    $articleStatusId = Article::STATUS_LIMITED;
                }
            }
        }

        return $articleStatusId;
    }

    static function add($wikiId, $parentArticleId = null, $createOrEdit = false)
    {
        try{
            if(!Article::where('wiki_id', $wikiId)->first()){
                $model = Article::create([
                    'wiki_id' => $wikiId,
                    'parent_article_id' => $parentArticleId,
                ]);
                return $model;
            }
        }catch (\Exception $e){}

        if($createOrEdit){
            $model = Article::where('wiki_id', $wikiId);
            if(!empty($parentArticleId)){
                $model = $model->where('parent_article_id', $parentArticleId);
            }else{
                $model = $model->whereNull('parent_article_id');
            }
            return $model->first();
        }

        return false;

    }

    static function updateArticleFromWiki($wikiId, $parentArticleId = false, $weight = false, $forceTitle = false, $contentsUpdateOnly = false)
    {
        if(!empty($wikiId)){
            $model = Article::where('wiki_id', $wikiId)->with('data_article')->first();
            if(!empty($model->data_article) && !empty($model->data_article->wiki_title)){
                $forceTitle = !empty($forceTitle) ? $forceTitle : $model->title;
                $weight = $weight !== false ? $weight : $model->weight;
                $parentArticleId = $parentArticleId !== false ? $parentArticleId : $model->parent_article_id;

                return Article::createArticlesWithTitles($model->data_article->wiki_title, $parentArticleId, $weight, $forceTitle, 1, true, $contentsUpdateOnly);
            }
        }

        return false;
    }

    static function updateArticleImage($wikiId, $image)
    {
        $model = is_object($wikiId) ? $wikiId : Article::where('wiki_id', $wikiId)->first();

        if(!empty($model)){
            $wikiId = $model->wiki_id;

            if(!empty($model->image)){
                foreach (Article::IMAGE_PATHS as $imagePath){
                    FileRepository::fileDelete($model->image->name, $imagePath);
                }
            }
            if(is_string($image)){
                $uploadedImageUrls = FileRepository::saveImageFromUrl($image, Article::IMAGE_PATHS, $wikiId, Article::IMAGE_WIDTHS, Article::IMAGE_HEIGHTS);
            }else{
                $uploadedImageUrls = FileRepository::saveImage($image, Article::IMAGE_PATHS, $wikiId, Article::IMAGE_WIDTHS, Article::IMAGE_HEIGHTS);
            }

            $model->image = !empty($uploadedImageUrls) && !empty($uploadedImageUrls[1]) ? FileRepository::getimagesize($uploadedImageUrls[0]) : null;
            if($model->save()){
                return $model;
            }
        }

        return false;
    }

    static function breadcrumbs($model, $getModels = false, $result = [], $count = 0)
    {
        if(empty($result)){
            if(!app()->runningInConsole() && !empty($model->data_article->breadcrumbs)){
                if($getModels){
                    return $model->data_article->breadcrumbs;
                }else{
                    $result = [];
                    foreach ($model->data_article->breadcrumbs as $breadcrumb){
                        $result[] = [$breadcrumb->id, $breadcrumb->title];
                    }
                    return $result;
                }
            }

            if($getModels){
                array_unshift($result, $model);
            }else{
                array_unshift($result, [0, $model->title]);
            }
        }

        if(!empty($model->parent_article_id)){
            $parentArticle = $model->parent_article;
            if($getModels){
                array_unshift($result, $parentArticle);
            }else{
                array_unshift($result, [$parentArticle->id, $parentArticle->title]);
            }
            if($count < 3){
                $result = self::breadcrumbs($parentArticle, $getModels, $result, $count+1);
            }
        }

        $result = array_values(array_filter($result));

        return $result;
    }

    //-----------------------------------

    static function createParentArticleWithTitle($title, $parentArticleId = null, $weight = 50, $forceTitle = false, $createOrEdit = true)
    {
        if(empty($title)){
            return [];
        }
        if(!empty($parentArticleId) && is_object($parentArticleId)){
            $parentArticleId = $parentArticleId->id;
        }

        $createdArticleIds = Article::createArticlesWithTitles($title, $parentArticleId, $weight, $forceTitle, 1, $createOrEdit);
        if(empty($createdArticleIds)){
            $title = preg_replace("/[-.!?:]{1,15}$/iu", "", $title);
            $createdArticleIds = Article::createArticlesWithTitles($title, $parentArticleId, $weight, $forceTitle, 1, $createOrEdit);
            if(empty($createdArticleIds)){
                Log::add([
                    'event'       => Log::EVENT_IF_ERROR,
                    'status'      => Log::STATUS_ERROR,
                    'description' => 'Article::createParentArticleWithTitle | skip article from edit | title = '.$title.' | parentArticleId = '.$parentArticleId,
                ]);
            }
        }

        return !empty($createdArticleIds) ? $createdArticleIds[0] : false;
    }

    static function createArticlesWithTitles($titles, $parentArticleId = null, $weight = 0, $forceTitle = false, $limit = false, $createOrEdit = false, $contentsUpdateOnly = false)
    {
        if(empty($titles) || Application::$isError){
            return [];
        }
        if(is_string($titles)){
            $titles = [$titles];
        }
        if(!empty($parentArticleId) && is_object($parentArticleId)){
            $parentArticleId = $parentArticleId->id;
        }

        $articles = [];
        if(!empty($limit)){
            foreach ($titles as $filteredTitle){
                $chunkArticles = WikiArticleRepository::getArticles($filteredTitle);

                if(!empty($chunkArticles)){
                    $articles = array_merge($articles, $chunkArticles);
                    $limit--;
                    if($limit <= 0){
                        break;
                    }
                }
            }
        }else{
            $articles = WikiArticleRepository::getArticles($titles);
        }
        $createdArticleIds = Article::createArticlesFromWikiArticles($articles, $parentArticleId, $weight, $forceTitle, $createOrEdit, $contentsUpdateOnly);
        return $createdArticleIds;
    }

    static function prepareTitle($title, $removeTextInBrackets = false)
    {
        if($removeTextInBrackets){
            $title = preg_replace("/\([^)]+\)/", "", $title);
            $title = StringClearRepository::clearDblSpace($title);
            $title = StringClearRepository::clearBracketsArtifacts($title);
        }
        $title = str_replace('—', '-', $title);
        $title = str_replace("'", '', $title);
        $title = str_replace("ʻ", '', $title);
        $title = StringClearRepository::normalize($title, true);
        $title = StringRepository::clearRepeatsReg($title);
        $title = StringRepository::clearSpace($title);
        return $title;
    }

    static function createArticlesFromWikiArticles($articles, $parentArticleId = null, $weight = 0, $forceTitle = false, $createOrEdit = false, $contentsUpdateOnly = false)
    {
        if(empty($articles)){
            return [];
        }
        if(is_string($articles)){
            $articles = [$articles];
        }
        if(!empty($parentArticleId) && is_object($parentArticleId)){
            $parentArticleId = $parentArticleId->id;
        }

        $createdArticleIds = [];

        foreach ($articles as $i => $article){
            if (Application::$isError) {
                return [];
            }
            if($model = Article::add($article->wikiId, $parentArticleId, $createOrEdit)){
                $reCall = 0;
                while (true){
                    try{
                        if($contentsUpdateOnly){
                            if(!empty($article->intro)){
                                $model->update([
                                    'intro' => $article->intro,
                                ]);
                            }

                            if(!empty($article->contents)){
                                $dataModel = $model->data_article;
                                $dataModel->update([
                                    'contents' => $article->contents,
                                ]);
                            }
                            $createdArticleIds[] = $model->id;
                        }else{
                            if(!empty($article->image)){
                                if(!empty($model->image)){
                                    foreach (Article::IMAGE_PATHS as $imagePath){
                                        FileRepository::fileDelete($model->image->name, $imagePath);
                                    }
                                }
                                $article->image = FileRepository::saveImageFromUrl($article->image, Article::IMAGE_PATHS, $article->wikiId, Article::IMAGE_WIDTHS, Article::IMAGE_HEIGHTS);
                            }

                            if(!empty($forceTitle)){
                                $articleTitle = is_array($forceTitle) ? $forceTitle[$i] : $forceTitle;
                            }else{
                                $articleTitle = $article->title;
                            }

                            $model->update([
                                'title' => Article::prepareTitle($articleTitle),
                                'intro' => $article->intro,
                                'image' => !empty($article->image) && !empty($article->image[0]) ? FileRepository::getimagesize($article->image[0]) : (!empty($model->image) ? $model->image : null),
                                'weight' => $weight,
                            ]);

                            if(!empty($model->data_article)){
                                $dataModel = $model->data_article;
                                $originTitle = !empty($dataModel->origin_title) ? $dataModel->origin_title : Article::prepareTitle($dataModel->wiki_title);
                                $dataModel->update([
                                    'wiki_title' => $article->title,
                                    'contents' => $article->contents,
                                    'origin_title' => !empty($originTitle) ? $originTitle : $model->title,
                                ]);

                                $createdArticleIds[] = $model->id;
                            }else{
                                Log::add([
                                    'event'       => Log::EVENT_IF_ERROR,
                                    'status'      => Log::STATUS_ERROR,
                                    'description' => 'App\Models\Article::saveWikiArticles | '.json_encode($model->toArray(), JSON_UNESCAPED_UNICODE),
                                ]);

                                foreach (Article::IMAGE_PATHS as $imagePath){
                                    FileRepository::fileDelete($imagePath.$article->wikiId.'.jpg', $imagePath);
                                }
                                $model->delete();
                            }
                        }
                        break;
                    }catch (\Exception $e){
                        Log::add([
                            'event'       => Log::EVENT_TRY_CATCH,
                            'status'      => Log::STATUS_ERROR,
                            'description' => 'App\Models\Article::saveWikiArticles $reCall = '.$reCall.' | '.$e->getMessage(),
                        ]);

                        $dataModel = $model->data_article;
                        echo "ERROR reCall=".$reCall." | ".$dataModel->id."\n";
                        $dataModel->update([
                            'wiki_status_id' => DataArticle::WIKI_STATUS_LOADING,
                        ]);
                        exit;

                        /*$reCall++;
                        if($reCall > 20){
                            break;
                        }else{
                            $dataModel->update([
                                'wiki_status_id' => DataArticle::WIKI_STATUS_LOADING,
                            ]);
                            exit;
                        }
                        sleep(rand(0, 10));*/
                    }
                }

            }
        }

        return $createdArticleIds;
    }

    static function filterSearchResultsOnExistId($searchResults = [], $getOnlyTitles = false, $createOrEditArticleWithParentId = false)
    {
        if(empty($searchResults)){
            return [];
        }

        if(!is_array($searchResults)){
            $searchResults = [$searchResults];
        }

        $allIds = [];
        foreach ($searchResults as $i => $searchResult){
            if(is_numeric($searchResult[1])){
                $allIds[] = $searchResult[1];
            }
        }

        $existIds = Article::whereIn('wiki_id', $allIds);
        if($createOrEditArticleWithParentId){
            $existIds->where('parent_article_id', '!=', $createOrEditArticleWithParentId);
        }
        $existIds = $existIds->get();
        if($existIds->isNotEmpty()){
            $existIds = $existIds->pluck('wiki_id')->all();
        }else{
            $existIds = [];
        }

        foreach ($searchResults as $i => $searchResult){
            if(in_array($searchResult[1], $existIds)){
                $searchResults[$i] = null;
            }else if($getOnlyTitles){
                $searchResults[$i] = $searchResult[0];
            }
        }

        $searchResults = array_values(array_filter($searchResults));

        return $searchResults;
    }

    static function isDefaultCustomArticleTitle($title)
    {
        if(in_array(mb_strtolower($title), AppConf::EMPTY_ARTICLE_TITLES) || is_int(str_replace('-', '', str_replace(' ', '', $title)))){
            return true;
        }
        return false;
    }
}
