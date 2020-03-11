<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * Class ProductCategory
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductCategory selectAll()
 */
class ProductCategory extends ModelBase
{
    protected $table = 'product_categories';
    public $timestamps = false;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id',
        'parent_product_category_id',
        'name_ua',
        'name_ru',
        'name_pl',
        'name_en',
        'image'
    ];

    public function products()
    {
        return $this->hasMany('App\Models\Product','product_category_id','id');
    }

    public function parent_product_category()
    {
        return $this->hasOne('App\Models\ProductCategory','id','parent_product_category_id');
    }

    public function  children_product_categories()
    {
        return $this->hasMany('App\Models\ProductCategory','parent_product_category_id','id');
    }

    public function all_children_product_categories()
    {
        return $this->children_product_categories()->with('all_children_product_categories');
    }

    public function property_categories()
    {
        return $this->belongsToMany(\App\Models\PropertyCategory::class,'product_property_categories','product_category_id','property_category_id');
    }
}
