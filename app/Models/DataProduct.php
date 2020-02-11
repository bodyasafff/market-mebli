<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataProduct extends Model
{
    static $notParseObjectData = false;
    protected $table = 'data_products';
    public $timestamps = false;
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    const IMAGES_COUNT = 2;

    protected $fillable = [
        'id',
        'created_at',
        'description_ua',
        'description_ru',
        'description_pl',
        'description_en',
        'images'
    ];

//    protected $attributes = [
//        'images' => DataProduct::images
//    ];

    public function setImagesAttribute($value)
    {
        $this->attributes['images'] = is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : '[]';
    }

    public function getImagesAttribute($value)
    {
        if(self::$notParseObjectData){
            return $value;
        }
        $value = !empty($value) ? json_decode($value) : [];
        return !empty($value) ? $value : [];
    }

    public function product()
    {
        return $this->hasOne('App\Models\Product','id','id');
    }

}
