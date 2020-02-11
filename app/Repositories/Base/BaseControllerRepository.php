<?php

namespace App\Repositories\Base;

class BaseControllerRepository
{
    static function loadToModelBase(&$model, $request, $fields = [], $updateForce = false, $save = false)
    {
        foreach ($fields as $field){
            if($updateForce){
                $model->{$field} = !isset($request->{$field}) ? null : $request->{$field};
            }else{
                $model->{$field} = !isset($request->{$field}) ? $model->{$field} : $request->{$field};
            }
        }
        if($save){
            return $model->save();
        }
    }

    static function loadToModelBool(&$model, $request, $fields = [])
    {
        foreach ($fields as $field){
            $model->{$field} = $request->{$field} ? 1 : 0;
        }
    }
}