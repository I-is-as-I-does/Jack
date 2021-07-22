<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */
namespace SSITU\Jack;

class Arrays
{

    public static function unsetNestedColumn($arr, $columnKey){
        array_walk($arr, function (&$a, $k) use ($columnKey) {
            if(array_key_exists($columnKey, $a)){
                unset($a[$columnKey]); 
            }          
          });
    }

    public static function sortNestedByKey($arr, $key)
    {
        uasort($arr, function ($a, $b) use ($key) {
            if ($a[$key] == $b[$key]) {
                return 0;
            }
            return ($a[$key] > $b[$key]) ? 1 : -1;
        });
        return $arr;
    }

    public static function sortByKey($arr, $key, $order = SORT_ASC)
    {

        $col = array_column($arr, $key);
        array_multisort($col, $order, $arr);
        return $arr;
    }

    public static function emptyItmsKeys($arr)
    {
        return array_keys(self::filterNonEmptyItms($arr));
    }

    public static function filterEmptyItms($arr)
    {
        return array_filter($arr, function ($itm) {return !empty($itm);});
    }

    public static function filterNonEmptyItms($arr)
    {
        return array_filter($arr, function ($itm) {return empty($itm);});
    }

    public static function allItmsAreEmpty($arr)
    {
        return self::filterNonEmptyItms($arr) === $arr;
    }

    public static function noItmsAreEmpty($arr)
    {
        return self::filterEmptyItms($arr) === $arr;
    }

    public static function countEmptyItms($arr)
    {
        return count(self::filterNonEmptyItms($arr));
    }

    public static function allItemsAreInt($arr)
    {
        return array_filter($arr, 'is_int') === $arr;
    }

    public static function allItemsAreString($arr)
    {
        return array_filter($arr, 'is_string') === $arr;
    }

    public static function merge($originValues, $newValues)
    {
        return $newValues + $originValues;
    }

    public static function flatten($itm, $out = [], $key = '')
    {
        if (is_array($itm)) {
            foreach ($itm as $k => $v) {
                $out = self::flatten($v, $out, trim($key . '.' . $k, '.'));
            }
        } else {
            $out[$key] = $itm;
        }
        return $out;
    }

    public static function reIndex($arr, $startAt = 0)
    {
        return (0 == $startAt)
        ? array_values($arr)
        : array_combine(range($startAt, count($arr) + ($startAt - 1)), array_values($arr));
    }

    public static function longestItm($arr)
    {if (!empty($arr)) {
        return max(self::strlenItms($arr));
    }
        return 0;
    }

    public static function longestKey($arr)
    {if (!empty($arr)) {
        return max(self::strlenItms(array_keys($arr)));
    }
        return 0;
    }

    public static function strlenItms($arr)
    {
        return array_map('strlen', $arr);
    }

    public static function highestKey($arr)
    {
        //@doc: works with string keys too (alphabetical order)
        if (empty($arr)) {
            return 0;
        }
        return max(array_keys($arr));
    }

    public static function highestIntKey($arr)
    {
        if (!empty($arr)) {
            $intKeys = array_filter(array_keys($arr), 'is_int');
            if (!empty($intKeys)) {
                return max($intKeys);
            }
        }
        return 0;
    }
}
