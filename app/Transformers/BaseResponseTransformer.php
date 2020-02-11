<?php

namespace App\Transformers;

class BaseResponseTransformer
{
    static function baseLists($data, $withAttributes = [])
    {
        if(empty($data)){
            return [];
        }
        return $data->map(function ($model) use ($withAttributes) {
            return self::base($model, $withAttributes);
        });
    }

    static function base($data, $withAttributes = [])
    {
        $attributes = [
            'id',
            'name'
        ];
        return collect($data)->only(array_merge($attributes, $withAttributes))->all();
    }

    static function basePaginate($data, $withAttributes = [])
    {
        if(empty($withAttributes)){
            return $data->items();
        }
        return collect($data)->only($withAttributes)->all();
    }
}