<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * Class Product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product selectAll()
 */
class Product extends ModelBase
{
    protected $table = 'products';
    public $timestamps = false;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $casts = [
        'id' => 'int',
        'product_category_id' => 'int',
        'sale_id' => 'int',
    ];

    protected $fillable = [
        'product_category_id',
        'sale_id',
        'name_ua',
        'name_ru',
        'name_pl',
        'name_en',
        'image'
    ];

    public function product_category()
    {
        return $this->hasOne('App\Models\ProductCategory','id','product_category_id');
    }

    public function data_product()
    {
        return $this->hasOne('App\Models\DataProduct','id','id');
    }

    public function properties()
    {
        return $this->belongsToMany(\App\Models\Property::class,'product_property','product_id','property_id');
    }
}