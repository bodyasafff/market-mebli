<?php

namespace App\Repositories\Base;

use App\AppConf;
use App\Repositories\BaseRepository;
use ForceUTF8\Encoding;
use Illuminate\Support\Str;

class StringRepository extends StringClearRepository
{
    static $abc = [
        'en' => ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'],
        'ru' => ['А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я'],
        'num' => ['1', '2', '3', '4', '5', '6', '7', '8', '9'],
    ];

    static $plChars = 'äöüÄÖÜßąĄćĆęĘłŁńŃóÓśŚźŹżŻŠŽšžŸŔÁÂĂÄĹÇČÉĘËĚÍÎĎŃŇÓÔŐÖŘŮÚŰÜÝŕáâăäĺçčéęëěíîďńňóôőöřůúűüý˙ŢţĐđßŒœĆćľ';
    const CYRILLIC_CHARS = 'абвгдежзийклмнопрстуфхцчшщюяьыёъэїіє';

    static function getOnlyCharsLen($str)
    {
        return mb_strlen(StringRepository::clearSpace(strip_tags($str)));
    }

    static function removeLastWord($str)
    {
        $str = trim($str);
        if(!empty($str) && mb_stripos($str, ' ') !== false){
            $str = ParseRepository::explode(' ', -1, $str);
            $str = array_slice($str, 0, -1);
            $str = implode(' ', $str);
        }
        return $str;
    }

    static function cyrillicChars($register = 'lower|upper')
    {
        if($register == 'lower'){
            return self::CYRILLIC_CHARS;
        }else if($register == 'upper'){
            return mb_strtoupper(self::CYRILLIC_CHARS);
        }
        return self::CYRILLIC_CHARS.mb_strtoupper(self::CYRILLIC_CHARS);
    }

    static function addSpaceBetweenTags($str)
    {
        $str = str_replace('>', '> ', $str);
        $str = str_replace('<', ' <', $str);
        return $str;
    }

    static function implode($glue, $arr = [])
    {
        if(empty($arr)){
            return '';
        }
        return is_array($arr) ? implode($glue, $arr) : '';
    }

    /*static function slug($str, $model = null, $ignoreId = null, $field = 'slug')
    {
        if(empty($str)){
            $str = microtime(true);
        }
        $str = self::replace('.', $str, '-');
        $str = self::replace('и', $str, 'ы');
        $str = Str::slug($str);
        if(!empty($model)){
            $query = $model::where($field, $str);
            if(!empty($ignoreId)){
                $query->where('id', '!=', $ignoreId);
            }
            if($query->first()){
                $str .= '-'.self::replace('.', microtime(true), '-');
            }
        }
        return $str;
    }*/

    static function urldecode($url)
    {
        return str_replace(['%3A', '%2F'], [':', '/'], urlencode($url));
    }

    static function pregQuote($str)
    {
        $str = preg_quote($str);
        $str = str_replace(' ', '\s', $str);
        return $str;
    }

    static function substrCount($search, $str, $isSearchRegular = false)
    {
        if(!$isSearchRegular) {
            $search = self::pregQuote($search);
            $search = '[\W]'.$search.'[\W]';
        }
        preg_match_all('#'.$search.'#siu', $str, $matches);
        return count($matches[0]);
    }

    static function contains($search, $str, $isSearchRegular = false)
    {
        if(!$isSearchRegular) {
            $search = self::pregQuote($search);
        }
        preg_match('#'.$search.'#siu', ' '.$str.' ', $matche);
        return !empty($matche);
    }

    static function startsWith($search, $str, $isSearchRegular = false)
    {
        if(!$isSearchRegular){
            $search = self::pregQuote($search);
        }
        preg_match('#^'.$search.'#siu', $str, $matche);
        return !empty($matche);
    }

    static function endsWith($search, $str, $isSearchRegular = false)
    {
        if(!$isSearchRegular) {
            $search = self::pregQuote($search);
        }
        preg_match('#'.$search.'$#siu', $str, $matche);
        return !empty($matche);
    }

    static function replaceBegin($search, $str, $replaceTo = '', $isSearchRegular = false)
    {
        $originStr = $str;
        if($search == $str){
            return $str;
        }
        if(!$isSearchRegular) {
            $search = self::pregQuote($search);
        }
        $str = preg_replace('#^'.$search.'#siu', $replaceTo, $str);
        $str = StringClearRepository::clearDblSpace($str);
        return !empty($str) ? $str : $originStr;
    }

    static function replaceEnd($search, $str, $replaceTo = '', $isSearchRegular = false)
    {
        if(!$isSearchRegular) {
            $search = self::pregQuote($search);
        }
        $str = preg_replace('#'.$search.'$#siu', $replaceTo, $str);
        $str = StringClearRepository::clearDblSpace($str);
        return $str;
    }

    static function replaceWithout($search, $str, $replaceTo = '', $isSearchRegular = false, $without = '')
    {
        return self::replace($search, $str, $replaceTo, $isSearchRegular, $without);
    }

    static function replaceAllWithout($str, $replaceTo = '', $without = '')
    {
        return self::replace('(.*?)', $str, $replaceTo, true, $without);
    }

    static function getOnlyChars($str)
    {
        if(empty($str)){
            return $str;
        }

        $str = self::replaceWithoutWord($str, '', false);
        $str = str_replace('-', ' ', $str);
        $str = str_replace('.', ' ', $str);
        $str = self::clearDblSpace($str);
        return $str;
    }

    static function replaceWithoutWord($str, $replaceTo = ' ', $withoutNumbers = true, $withBaseTextChars = false)
    {
        //$without = 1234567890
        $str = self::replaceEnd('-', $str);
        $str = self::replaceBegin('-', $str);

        $withBaseTextChars = !empty($withBaseTextChars) ? '?,:' : '';

        if(AppConf::NOT_USE_LATIN_AND_CYRILLIC){
            if($withoutNumbers === true){
                $str =  self::replace('[\W\d1234567890.-'.$withBaseTextChars.']', $str, $replaceTo, true, '1234567890.-'.$withBaseTextChars);
            }else{
                $str = preg_replace('/[\W\d-]/iu', '', $str);
            }
        }else{
            if(!empty($withoutNumbers) && is_string($withoutNumbers)){
                $str = preg_replace('/[^'.$withoutNumbers.'a-zA-Zа-яА-ЯёЁ\s-]/iu', '', $str);
            }else if($withoutNumbers === true){
                $str =  self::replace('[\W\d1234567890.-'.$withBaseTextChars.']', $str, $replaceTo, true, '1234567890.-'.$withBaseTextChars);
                //$str =  self::replaceAllWithout($str, $replaceTo, '[a-z'.StringRepository::cyrillicChars().'-]');
            }else{
                $str = preg_replace('/[^a-zA-Zа-яА-ЯёЁ\s-]/iu', '', $str);
            }
        }

        return $str;
        //return self::replaceAllWithout($str, $replaceTo, '[a-z'.StringRepository::cyrillicChars().'-]');
    }

    static function replace($search, $str, $replaceTo = '', $isSearchRegular = false, $without = '')
    {
        if(empty($str)){
            return '';
        }

        if(is_array($search)){
            foreach ($search as $s){
                $str = self::replace($s, $str, $replaceTo, $isSearchRegular, $without);
            }
            return $str;
        }

        $replaceTo = is_array($replaceTo) ? $replaceTo[rand(0, count($replaceTo)-1)] : $replaceTo;

        if(empty($search)){
            if(empty($without)){
                $without = '[a-z'.StringRepository::cyrillicChars().'-]';
            }
            $search = '(.*?)';
            $isSearchRegular = true;
        }

        if(!$isSearchRegular) {
            $search = self::pregQuote($search);
        }

        if(!empty($without)){
            preg_match_all('#'.$search.'#siu', $str, $matches);
            foreach ($matches[0] as $i => $v){
                $v = trim($v);
                if(empty($v) || mb_strripos($without, $v) !== false){
                    $matches[0][$i] = false;
                }else{
                    $matches[0][$i] = $v;
                }
            }

            if(empty($matches) || empty($matches[0])){
                return $str;
            }
            $matches = BaseRepository::clearEmptyElementsInArray($matches[0], true);

            $search = self::implode('', $matches);
            $search = StringClearRepository::clearDblSpace($search);
            $search = self::replace(' ', $search);

            if(empty($search)){
                return $str;
            }
            $search = '['.self::pregQuote($search).']';
        }


        $str = preg_replace('#'.Encoding::toUTF8($search).'#siu', $replaceTo, $str);
        $str = StringClearRepository::clearDblSpace($str);

        return $str;
    }

    static function getBetween($searchFrom, $searchTo, $str, $isSearchRegular = false, $ignoreCase = true)
    {
        if(empty($str)){
            return '';
        }
        if(!$isSearchRegular) {
            if(!empty($searchFrom)){
                $searchFrom = self::pregQuote($searchFrom);
            }
            if(!empty($searchTo)){
                $searchTo = self::pregQuote($searchTo);
            }
        }
        if(!empty($searchFrom)) {
            $str = preg_replace('#^(.*?)' . $searchFrom . '#' . (!empty($ignoreCase) ? 'i' : '') . 'us', '', $str);
        }
        if(!empty($searchTo)) {
            $str = preg_replace('#' . $searchTo . '(.*?)$#' . (!empty($ignoreCase) ? 'i' : '') . 'us', '', $str);
        }
        $str = StringClearRepository::clearDblSpace($str);
        return $str;
    }

    static function uniqueChars($str)
    {
        preg_match_all('#(.*?)#siu', $str, $matches);
        if(!empty($matches[0])){
            $matches = BaseRepository::clearEmptyElementsInArray($matches[0], true);
            return implode('', $matches);
        }
        return $str;
    }

    static function mbUcfirst($string, $strtolower = false, $enc = 'UTF-8')
    {
        if($strtolower){
            $string = mb_strtolower($string);
        }
        return mb_strtoupper(mb_substr($string, 0, 1, $enc), $enc) . mb_substr($string, 1, mb_strlen($string, $enc), $enc);
    }

    static function mbUcfirstWords($string, $firstWord = false, $enc = 'UTF-8')
    {
        $string = explode(' ', $string);
        foreach ($string as $i => $item){
            $item = mb_strtolower($item);
            if($firstWord != -1 && (mb_strlen($item) > 2 || $i == 0)){
                $string[$i] = self::mbUcfirst($item, $enc);
                if($firstWord){
                    $firstWord = -1;
                }
            }else{
                $string[$i] = $item;
            }
        }

        return implode(' ', $string);
    }

    static function splitHalf($string, $center = 0.5) {
        $length2 = strlen($string) * $center;
        $tmp = explode(' ', $string);
        $index = 0;
        $result = ['', ''];
        foreach($tmp as $word) {
            if(!$index && strlen($result[0]) > $length2) $index++;
            $result[$index] .= $word.' ';
        }
        return $result;
    }

    //-----------------------------------------------------------------

    static function strpos($value, $chars = [])
    {
        foreach ($chars as $char) {
            if($str = strpos($value, $char)){
                $value = mb_substr($value, 0, $str);
            }
        }
        return $value;
    }

    //---------------------------------------------------------

    static function allArrayPermutations ($items, $perms = array(), &$result = []) {
        $firstRun = empty($result) ? true : false;
        if (empty($items)) {
            $tmp_result = '';
            foreach ($perms as $perm){
                $tmp_result .=  !empty($perm) && empty(stristr($tmp_result, $perm)) ? ' ' . $perm : '';
            }
            $result[] = $tmp_result;
        } else {
            for ($i = count($items) - 1; $i >= 0; --$i) {
                $newitems = $items;
                $newperms = $perms;
                list($foo) = array_splice($newitems, $i, 1);
                array_unshift($newperms, $foo);
                self::allArrayPermutations($newitems, $newperms, $result);
            }
        }
        if($firstRun){
            return implode(', ', $result);
        }
    }
}