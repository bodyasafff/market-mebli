<?php

namespace App\Models\Datasets;

use Illuminate\Support\Arr;

/**
 * Class ModelBase
 */
class Dataset
{
    static $data;
    public $result;

    static function implodeIds($separator = ',')
    {
        $result = [];
        foreach (static::$data as $i => $v){
            $result[] = $v['id'];
        }
        return implode($separator, $result);
    }

    static function removeLastDataItem()
    {
        if(!empty(static::$data)){
            array_pop(static::$data);
        }
    }

    static function findById($id, $asObject = false)
    {
        foreach (static::$data as $v){
            if($v['id'] == $id){
                if($asObject){
                    return (object)$v;
                }
                return $v;
            }
        }
        return null;
    }

    static function nameById($id)
    {
        foreach (static::$data as $v){
            if($v['id'] == $id){
                return $v['name'];
            }
        }
        return null;
    }

    static function fieldById($id, $field)
    {
        foreach (static::$data as $v){
            if($v['id'] == $id){
                return $v[$field];
            }
        }
        return null;
    }

    static function all()
    {
        return static::$data;
    }

    static function only($fields = [])
    {
        return collect(static::$data)->map(function ($data) use ($fields){
            return collect($data)->only($fields)->all();
        })->all();
    }

    static function except($fields = [], $notRemove = false)
    {
        return collect(static::$data)->map(function ($data) use ($fields, $notRemove){
            if($notRemove){
                $data = (array)$data;
                foreach ($fields as $field){
                    $data[$field] = null;
                }
                return (object)$data;
            }else{
                return collect(static::$data)->except($fields)->all();
            }
        })->all();
    }

    static function first()
    {
        return !empty(static::$data) ? static::$data[0] : null;
    }

    /*---------------------------------*/

    static function find()
    {
        $_this = new self();
        $_this->result = self::convertToObject(static::$data);
        return $_this;
    }

    static function where($where, $prepend = [])
    {
        $data = static::$data;
        $data = Arr::where($data, function ($value, $key) use ($where) {
            if(is_string($where) || count($where) == 1){
                return !empty($value[$where]);
            }else if(count($where) == 3){
                if($where[1] == '!='){
                    return !isset($value[$where[0]]) || $value[$where[0]] != $where[2];
                }else{
                    return isset($value[$where[0]]) && $value[$where[0]] == $where[2];
                }
            }else{
                return isset($value[$where[0]]) && $value[$where[0]] == $where[1];
            }
        });

        if(!empty($prepend)){
            $data = array_merge([$prepend], $data);
        }

        return self::convertToObject($data);
    }

    static function findAll($prepend = [])
    {
        $data = static::$data;
        if(!empty($prepend)){
            $data = array_merge([$prepend], $data);
        }

        return self::convertToObject($data);
    }

    public function get()
    {
        return $this->result;
    }

    static function getRandomId()
    {
        if(!empty(static::$data)){
            return static::$data[array_rand(static::$data, 1)]['id'];
        }else{
            return -1;
        }
    }

    /*-----------------------------------*/

    static function convertToObject($result)
    {
        foreach ($result as $i => $v){
            $result[$i] = (object)$v;
        }
        return $result;
    }
}
