<?php
namespace App\Helpers;

class FormatHelper
{
    static function price($expression)
    {
        $expression = explode('.', (string)$expression);
        $pennies = '';
        if(!empty($expression[1])){
            if(strlen($expression[1]) == 1){
                $pennies = '.'.$expression[1].'0';
            }
        }else if(!empty($expression[0])){
            $pennies = '.00';
        }
        return $expression[0].$pennies;
    }

    static function age($birthday_at)
    {
        return !empty($birthday_at) ? (new \DateTime($birthday_at))->diff(new \DateTime('now'))->format('%y') : null;
    }
}