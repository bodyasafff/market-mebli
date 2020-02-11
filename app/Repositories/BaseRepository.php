<?php

namespace App\Repositories;

use App\Repositories\Base\StringClearRepository;
use App\Repositories\Base\StringRepository;
use Carbon\Carbon;
use Illuminate\Support\Str;

class BaseRepository
{
    static function slugZh($string)
    {
        $slug = mb_strtolower(
            preg_replace('/([?]|\p{P}|\s)+/u', '-', $string)
        );
        return trim($slug, '-');
    }

    static function slug($str, $default = false, $extension = '')
    {
        $str = str_replace('.', '-', $str);
        $str = str_replace('/', '-', $str);
        $str = trim($str);

        if($str != '-' && !empty($str)){
            if(config('app.locale') == 'zh'){
                $str = self::slugZh($str);
            }else{
                $str = Str::slug($str);
            }
        }else{
            $str = $default === false ? substr((string)time(), 3).''.rand(111111,999999) : $default;
        }

        $str = !empty($str) ? $str : ($default === false ? substr((string)time(), 3).''.rand(111111,999999) : $default);
        return Str::finish($str, $extension);
    }

    static function paginate($model, $parametersPaginate = [])
    {
        $parametersPaginate = self::parametersPaginate($parametersPaginate);
        return $model->paginate($parametersPaginate['per_page'], ['*'], 'page', $parametersPaginate['page']);
    }

    static function parametersPaginate($request)
    {
        if($request->all){
            $request->per_page = 999999;
        }
        return [
            'page'     => $request->page ? $request->page : 1,
            'per_page' => $request->per_page ? $request->per_page : config('models.*.per_page', 15),
        ];
    }

    static function prepareLoadRelation($data = [], $prefix = '', $only = false)
    {
        if(empty($data) || empty($prefix)){
            return $data;
        }
        $data = collect($data)->map(function ($item, $key) use ($prefix){
            return $prefix.'.'.$item;
        })->all();
        return $only ? $data : array_merge([$prefix], $data);
    }

    static function echoLog($value)
    {
        echo Carbon::now()->format('m-d H:i:s').' | '.$value;
    }

    static function sendCurlGetRequest($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($curl, CURLOPT_TIMEOUT, 120);

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }

    static function clearEmptyElementsInArray($arr, $unique = false, $toLowerCaseAll = false)
    {
        if (!empty($arr) && is_array($arr)) {
            if($toLowerCaseAll){
                foreach ($arr as $i => $item){
                    $item = StringRepository::clearSpace($item);
                    if(!empty($item)){
                        $arr[$i] = mb_strtolower($item);
                    }else{
                        $arr[$i] = null;
                    }
                }
            }

            if($unique && is_array($arr)){
                $arr = array_unique($arr);
            }
            return array_values(array_filter($arr, function ($item) {
                return !empty($item);
            }));
        }
        return [];
    }

    //------------------------------------------

    static function notEmptyVar($var, $methods = [], $isset = false)
    {
        if(($isset && isset($var)) || !empty($var)){
            if(!is_array($methods)){
                $methods = [$methods];
            }

            foreach ($methods as $j => $methodsTmp){
                $varTmp = $var;
                $methodsTmp = explode('.', $methodsTmp);
                $methodsTmpCount = count($methodsTmp);
                if(($isset && isset($varTmp)) || !empty($varTmp)){
                    foreach ($methodsTmp as $i => $method){
                        if(
                            ($isset && (
                                is_array($varTmp) ? isset($varTmp[$method]) : isset($varTmp->{$method})
                                )
                            ) || (
                            is_array($varTmp) ? !empty($varTmp[$method]) : !empty($varTmp->{$method})
                            )
                        ){
                            if($i >= $methodsTmpCount - 1){
                                break;
                            }
                            $varTmp = is_array($varTmp) ? $varTmp[$method] : $varTmp->{$method};
                        }else{
                            return false;
                        }
                    }
                }
            }
        }else{
            return false;
        }
        return true;
    }

    static function issetVar($var, $methods = '')
    {
        return self::notEmptyVar($var, $methods, true);
    }

    static function stripTagsWithContent($str)
    {
        preg_match_all("|<[^>]+>(.*)</[^>]+>|U", $str, $matches);
        $str = StringRepository::implode(' ', $matches);
        $str = StringClearRepository::clearDblSpace($str);
        return $str;
    }

    static function stripTags($str, $allowableTags = null)
    {
        if(empty($str)){
            return $str;
        }
        $str = StringRepository::addSpaceBetweenTags($str);
        $str = strip_tags($str, $allowableTags);
        $str = StringClearRepository::clearDblSpace($str);
        return $str;
    }
}