<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */
namespace SSITU\Jack\Trades;

class Arrays implements Arrays_i
{

    public function allItemsAreInt($array)
    {
        return array_filter($array, 'is_int') === $array;
    }

    public function allItemsAreString($array)
    {
        return array_filter($array, 'is_string') === $array;
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
