<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

/**
 * Class ModelBase
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModelBase selectAll()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModelBase exclude($exclude = array())
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModelBase excludeLanguage($language = null, $exclude = [])
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModelBase active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModelBase paginateSimple($next = false)
 * @mixin \Eloquent
 */
class ModelBase extends Model
{
    const PAGINATE_LIMIT = 12;

    static function implodeIds()
    {
        return static::get()->implode('id', ',');
    }

	public function columns()
	{
	    if(!empty($this->fillable)){
	        $columns = $this->fillable;
	        if(isset($this->casts['id']) && !isset($this->fillable['id'])){
                $columns[] = 'id';
            }
            return $columns;
        }
        return [];
	}

    public function scopeStatusRange($query, $statusRange)
    {
        return $query->where('status_id', '>=', $statusRange[0])->where('status_id', '<=', $statusRange[1]);
    }

    public function scopePaginateSimple($query, $next = false)
    {
        $limit = self::PAGINATE_LIMIT;
        $offset = 0;
        $page = 1;
        $request = request();

        if(!empty($request)){
            if($next){
                $page = !empty($request->page) ? $request->page + 1 : 2;
            }else if(is_numeric($request)){
                $page = $request;
            }else{
                $request = is_array($request) ? (object)$request : $request;
                $page = !empty($request->page) ? $request->page : $page;
            }
            $offset = $page > 1 ? ($page-1) * self::PAGINATE_LIMIT : 0;
        }

        return $query->offset($offset)->limit($limit);
    }

    public function scopeActive($query)
    {
        return $query->whereIsActive(1);
    }

    public function scopeSelectAll($query)
    {
        return $query;
    }

    public function scopeExclude($query, $exclude = [])
    {
        return $query->select(array_diff($this->columns(), $exclude));
    }

    public function scopeExcludeLanguage($query, $language = 'ua', $exclude = [])
    {
        $languageExclude = $language == 'ua' ? 'en' : 'ua';
        foreach ($this->fillable as $field){
            $fieldExplode = explode('_', $field);
            if($fieldExplode[count($fieldExplode)-1] == $languageExclude){
                $exclude[] = $field;
            }
        }

        return $query->select(array_diff($this->columns(), $exclude));
    }

    public static function getDefaultHiddens() {
        return with(new static)->getHiddens();
    }

    public function getHiddens(){
        return $this->hidden;
    }

    static function incrementAllNextRecords($fromId = 0, $table = null)
    {
        $table = $table ? $table : (new static())->getTable();

        \DB::beginTransaction();
        \DB::update('UPDATE '.$table.' SET id = id + 1 WHERE id >= '.$fromId.' order by id DESC;');
        \DB::commit();
    }

    static function resetAutoIncrement($table = null)
    {
        $table = $table ? $table : (new static())->getTable();

        \DB::statement("ALTER TABLE ".$table." AUTO_INCREMENT = 1;");
    }

    static function activeAllChildrens($model, $childrensRelation, $fieldName, $isActive = 1)
    {
        if(isset($model->{$childrensRelation})){
            foreach ($model->{$childrensRelation} as $item){
                $item->update([
                    $fieldName => $isActive
                ]);
                self::activeAllChildrens($item, $childrensRelation, $fieldName, $isActive);
            }
        }
    }

    static function activeAllParents($model, $parentRelation, $childrensRelation, $fieldName, $isActive = 1)
    {
        if(isset($model->{$parentRelation})){
            if($isActive){
                $model->{$parentRelation}->update([$fieldName => 1]);
                self::activeAllParents($model->{$parentRelation}, $parentRelation, $childrensRelation, $fieldName, $isActive);
            }else{
                if(!$model->{$childrensRelation}->where($fieldName, 1)->all()){
                    $model->{$parentRelation}->update([$fieldName => 0]);
                    self::activeAllParents($model->{$parentRelation}, $parentRelation, $childrensRelation, $fieldName, $isActive);
                }
            }
        }
    }
}
