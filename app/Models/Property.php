<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * Class Product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Property selectAll()
 */
class Property extends ModelBase
{
    protected $table = 'properties';
    public $timestamps = false;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id',
        'parent_property_id',
        'property_category_id',
        'name_ua',
        'name_ru',
        'name_pl',
        'name_en',
        'weight'
    ];

    public function property_category()
    {
        return $this->hasOne('App\Models\PropertyCategory','id','property_category_id');
    }

    public function products()
    {
        return $this->belongsToMany(\App\Models\Product::class,'product_property','property_id','product_id');
    }


}