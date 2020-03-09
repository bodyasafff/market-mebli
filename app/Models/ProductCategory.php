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

    public function property_categories()
    {
        return $this->belongsToMany(\App\Models\PropertyCategory::class,'product_property_categories','product_category_id','property_category_id');
    }
}
