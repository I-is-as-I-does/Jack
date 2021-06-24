<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */
namespace SSITU\Jack\Trades;

class Arrays implements Arrays_i
{

    public function sortNestedByKey($arr, $key)
    {

        uasort($arr, function ($a, $b) use ($key) {
            if ($a[$key] == $b[$key]) {
                return 0;
            }

            return ($a[$key] > $b[$key]) ? 1 : -1;
        });
        return $arr;
    }

    public function sortByKey($arr, $key)
    {

        $col = array_column($arr, $key);
        array_multisort($col, SORT_ASC, $arr);
        return $arr;
    }

    public function allItemsAreEmpty($arr)
    {
        return array_filter($arr, function ($itm) {return empty($itm);}) === $arr;
    }

    public function allItemsAreInt($arr)
    {
        return array_filter($arr, 'is_int') === $arr;
    }

    public function allItemsAreString($arr)
    {
        return array_filter($arr, 'is_string') === $arr;
    }

    public function merge($originValues, $newValues)
    {
        return $newValues + $originValues;
    }

    public function flatten($itm, $out = [], $key = '')
    {
        if (is_array($itm)) {
            foreach ($itm as $k => $v) {
                $out = $this->flatten($v, $out, trim($key . '.' . $k, '.'));
            }
        } else {
            $out[$key] = $itm;
        }
        return $out;
    }

    public function reIndex($arr, $startAt = 0)
    {
        // @author: Peter Bailey
        return (0 == $startAt)
        ? array_values($arr)
        : array_combine(range($startAt, count($arr) + ($startAt - 1)), array_values($arr));
    }

    public function longestItem($arr)
    {if (!empty($arr)) {
        return max($this->itemsStrlen($arr));
    }
        return 0;
    }

    public function longestKey($arr)
    {if (!empty($arr)) {
        return max($this->itemsStrlen(array_keys($arr)));
    }
        return 0;
    }

    public function itemsStrlen($arr)
    {
        return array_map('strlen', $arr);
    }
}
