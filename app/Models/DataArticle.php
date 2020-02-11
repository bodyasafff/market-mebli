<?php

namespace App\Models;

use App\AppConf;
use App\Repositories\Base\FileRepository;
use App\Repositories\Base\StringClearRepository;

/**
 * Class DataArticle
 *
 * @property int $id
 * @property string $wiki_title
 * @property string $origin_title
 * @property object $contents
 * @property object $breadcrumbs
 * @property object $cse_contents
 * @property object $cse_images
 * @property object $seo_contents
 * @property object $seo_keywords
 * @property object $seo_similar_queries
 * @property string $seo_search_query
 * @property int $cse_contents_status_id
 * @property int $cse_images_status_id
 * @property int $seo_status_id
 * @property int $turbo_status_id
 * @property int $wiki_status_id
 * @property int $wiki_update_status_id
 * @property int $tmp_image_status_id
 * @property int $translate_title_status_id
 * @property int $categorymembers_status_id
 * @property int $category_status_id
 * @property int $scout_status_id
 *
 * @property \App\Models\Article $article
 *
 * @package App\Models
 */
class DataArticle extends ModelBase
{
    protected $table = 'data_articles';
    protected $connection = AppConf::BASE_MYSQL_CONNECTION;
    public $incrementing = false;
    public $timestamps = false;

    const SCOUT_STATUS_NEW = 0;
    const SCOUT_STATUS_WAIT = 1;
    const SCOUT_STATUS_DONE = 11;
    const SCOUT_STATUS_EMPTY = 21;

    const SEO_STATUS_NEW = 0;
    const SEO_STATUS_WAIT = 1;
    const SEO_STATUS_DONE = 11;
    const SEO_STATUS_EMPTY = 21;

    const WIKI_STATUS_NEW = 0;
    const WIKI_STATUS_LOADING = 11;
    const WIKI_STATUS_LOADED = 21;
    const WIKI_STATUS_CUSTOM = 22;
    const WIKI_STATUS_EMPTY = 31;

    const WIKI_UPDATE_STATUS_NEW = 0;
    const WIKI_UPDATE_STATUS_UPDATED = 1;

    const CATEGORYMEMBERS_STATUS_NEW = 0;
    const CATEGORYMEMBERS_STATUS_CATEGORY = 1;
    const CATEGORYMEMBERS_STATUS_PAGE = 2;
    const CATEGORYMEMBERS_STATUS_MANUAL_PAGE = 3;

    const TRANSLATE_TITLE_STATUS_NEW = 0;
    const TRANSLATE_TITLE_STATUS_UPDATED = 1;
    const TRANSLATE_TITLE_STATUS_EMPTY = 2;

    const CATEGORY_STATUS_NEW = 0;
    const CATEGORY_STATUS_LOADED = 1;

    const TMP_IMAGE_STATUS_NEW = 0;
    const TMP_IMAGE_STATUS_LOADED = 1;

    const CSE_STATUS_NEW = 0;
    const CSE_STATUS_LOADED = 1;

    const TURBO_STATUS_NEW = 0;
    const TURBO_STATUS_LOADED = 1;

    const IMAGE_WIDTH = 640;

    static $notParseObjectData = false;
    static $getContentsWithoutIntro = false;

    protected $casts = [
        'seo_status_id' => 'int',
        'turbo_status_id' => 'int',
        'wiki_status_id' => 'int',
        'wiki_update_status_id' => 'int',
        'tmp_image_status_id' => 'int',
        'translate_title_status_id' => 'int',
        'categorymembers_status_id' => 'int',
        'category_status_id' => 'int',
        'scout_status_id' => 'int',
    ];

    protected $attributes = [
        'contents' => '[]',
        'breadcrumbs' => '[]',
        'cse_contents' => '[]',
        'cse_images' => '[]',
        'seo_contents' => '[]',
        'seo_keywords' => '[]',
        'seo_similar_queries' => '[]',
        'seo_status_id' => DataArticle::SEO_STATUS_NEW,
        'turbo_status_id' => DataArticle::TURBO_STATUS_NEW,
        'wiki_status_id' => DataArticle::WIKI_STATUS_NEW,
        'wiki_update_status_id' => DataArticle::WIKI_UPDATE_STATUS_UPDATED,
        'tmp_image_status_id' => DataArticle::TMP_IMAGE_STATUS_NEW,
        'translate_title_status_id' => DataArticle::TRANSLATE_TITLE_STATUS_UPDATED,
        'categorymembers_status_id' => DataArticle::CATEGORYMEMBERS_STATUS_MANUAL_PAGE,
        'category_status_id' => DataArticle::CATEGORY_STATUS_NEW,
        'scout_status_id' => DataArticle::SEO_STATUS_NEW,
        'cse_images_status_id' => DataArticle::CSE_STATUS_NEW,
        'cse_contents_status_id' => DataArticle::CSE_STATUS_NEW,
    ];

    protected $fillable = [
        'id',
        'wiki_title',
        'origin_title',
        'contents',
        'breadcrumbs',
        'cse_contents',
        'cse_images',
        'seo_contents',
        'seo_keywords',
        'seo_similar_queries',
        'seo_status_id',
        'turbo_status_id',
        'wiki_status_id',
        'wiki_update_status_id',
        'tmp_image_status_id',
        'translate_title_status_id',
        'categorymembers_status_id',
        'category_status_id',
        'scout_status_id',
        'seo_search_query',
        'cse_contents_status_id',
        'cse_images_status_id',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function(self $model)  {
            if(!empty($model->wiki_title) && empty($model->origin_title)){
                $model->origin_title = StringClearRepository::normalize($model->wiki_title);
                $model->origin_title = !empty($model->origin_title) ? $model->origin_title : $model->article->title;
            }
        });

        static::updating(function(self $model)  {
            if(!empty($model->wiki_title) && empty($model->origin_title)){
                $model->origin_title = StringClearRepository::normalize($model->wiki_title);
                $model->origin_title = !empty($model->origin_title) ? $model->origin_title : $model->article->title;
            }
        });
    }

    //-------------------------------

    public function article()
    {
        return $this->belongsTo(Article::class, 'id', 'id');
    }

    //-------------------------------

    public function getContentsAttribute($value)
    {
        if(self::$notParseObjectData){
            return $value;
        }
        $value = !empty($value) ? json_decode($value) : [];
        $value = !empty($value) ? $value : [];
        if(self::$getContentsWithoutIntro){
            return $value;
        }
        return !empty($this->article->intro) ? array_merge([$this->article->intro], $value) : $value;
    }

    public function setContentsAttribute($value)
    {
        $this->attributes['contents'] = is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : '[]';
    }

    public function getCseImagesAttribute($value)
    {
        if(self::$notParseObjectData){
            return $value;
        }
        if(!empty($value)){
            $value = json_decode($value);
            foreach ($value as $i => $v){
                $v = explode('||', $v);
                if(is_array($v) && count($v) == 3){
                    $value[$i] = (object)[
                        'url' => $v[0],
                        'width' => $v[1],
                        'height' => $v[2],
                    ];
                }
            }
            return $value;
        }
        return [];
    }

    public function setCseImagesAttribute($value)
    {
        if(is_string($value)){
            if(mb_strripos($value, '||') !== false && mb_strripos($value, '[') !== false){
                $this->attributes['cse_images'] = $value;
            }else{
                $this->attributes['cse_images'] = '[]';
            }
        }else if(is_array($value)){
            foreach ($value as $i => $v){
                $v = is_array($v) ? (object)$v : $v;
                if(is_object($v)){
                    $value[$i] = $v->url.'||'.$v->width.'||'.$v->height;
                }else if(!mb_strripos($v, '||')){
                    $v = FileRepository::getimagesize($v);
                    $value[$i] = $v->url.'||'.$v->width.'||'.$v->height;
                }
            }
        }

        $this->attributes['cse_images'] = is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : '[]';
    }

    public function getBreadcrumbsAttribute($value)
    {
        if(self::$notParseObjectData){
            return $value;
        }
        $value = !empty($value) ? json_decode($value) : [];
        return !empty($value) ? $value : [];
    }

    public function setBreadcrumbsAttribute($value)
    {
        $this->attributes['breadcrumbs'] = is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : '[]';
    }

    public function getCseContentsAttribute($value)
    {
        if(self::$notParseObjectData){
            return $value;
        }
        $value = !empty($value) ? json_decode($value) : [];
        return !empty($value) ? $value : [];
    }

    public function setCseContentsAttribute($value)
    {
        $this->attributes['cse_contents'] = is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : '[]';
    }

    public function getSeoContentsAttribute($value)
    {
        if(self::$notParseObjectData){
            return $value;
        }
        $value = !empty($value) ? json_decode($value) : [];
        return !empty($value) ? $value : [];
    }

    public function setSeoContentsAttribute($value)
    {
        $this->attributes['seo_contents'] = is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : '[]';
    }

    public function getSeoKeywordsAttribute($value)
    {
        if(self::$notParseObjectData){
            return $value;
        }
        $value = !empty($value) ? json_decode($value) : [];
        return !empty($value) ? $value : [];
    }

    public function setSeoKeywordsAttribute($value)
    {
        $this->attributes['seo_keywords'] = is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : '[]';
    }

    public function getSeoSimilarQueriesAttribute($value)
    {
        if(self::$notParseObjectData){
            return $value;
        }
        $value = !empty($value) ? json_decode($value) : [];
        return !empty($value) ? $value : [];
    }

    public function setSeoSimilarQueriesAttribute($value)
    {
        $this->attributes['seo_similar_queries'] = is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : '[]';
    }

    //--------------------------------------------

    static function checkWikiStatus($article, $dataArticle, $articleStatusId = null)
    {
        $articleStatusId = !empty($articleStatusId) ? $articleStatusId : $article->status_id;
        $dataArticleWikiStatusId = $dataArticle->wiki_status_id;

        if($dataArticleWikiStatusId > DataArticle::WIKI_STATUS_LOADING){
            if($article->id !== Article::HOME_ID && $article->wiki_id > 0){
                if($articleStatusId == Article::STATUS_PUBLIC){
                    $dataArticleWikiStatusId = DataArticle::WIKI_STATUS_LOADED;
                }else{
                    $dataArticleWikiStatusId = DataArticle::WIKI_STATUS_EMPTY;
                }
            }else{
                $dataArticleWikiStatusId = DataArticle::WIKI_STATUS_CUSTOM;
            }
        }

        return $dataArticleWikiStatusId;
    }
}
