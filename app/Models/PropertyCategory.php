<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * Class ProductCategory
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyCategory selectAll()
 */
class PropertyCategory extends ModelBase
{
    protected $table = 'property_categories';
    public $timestamps = false;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id',
        'parent_property_category_id',
        'name_ua',
        'name_ru',
        'name_pl',
        'name_en',
        'weight',
        'group_id',
    ];

    public function group()
    {
        return $this->hasOne('App\Models\Group','id','group_id');
    }

    public function properties()
    {
        return $this->hasMany('App\Models\Property','property_category_id','id');
    }

    public function product_categories()
    {
        return $this->belongsToMany(\App\Models\ProductCategory::class,'product_property_categories','property_category_id','product_category_id');
    }
}