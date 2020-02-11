<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    protected $table = 'products';
    public $timestamps = false;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id',
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
}