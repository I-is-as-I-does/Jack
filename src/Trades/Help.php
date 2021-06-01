<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */
namespace SSITU\Jack\Trades;

class Help implements Help_i
{
    public function isPostvInt($value)
    { //  @doc works even if $value is a string-integer
        return ((is_int($value) || ctype_digit($value)) && (int) $value > 0);
    }

    public function updateArray($basevalues, $updatevalues)
    {
        return $updatevalues + $basevalues;
    }

    public function isValidPattern($pattern)
    {
        $pattern = '/' . trim($pattern, '/') . '/';
        if (@preg_match($pattern, null) === false) {
            return false;
        }
        return true;
    }

    public function flattenOutput($itm, $out = [], $key = '')
    {
        if (is_array($itm)) {
            foreach ($itm as $k => $v) {
                $out = $this->flattenOutput($v, $out, $key . '.' . $k);
            }
        } else {
            $out[$key] = $itm;
        }
        return $out;
    }

    public function boolify($value)
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    public function num2alpha($n)
    { // @author: Theriault
        $r = '';
        for ($i = 1; $n >= 0 && $i < 10; $i++) {
            $r = chr(0x41 + ($n % pow(26, $i) / pow(26, $i - 1))) . $r;
            $n -= pow(26, $i);
        }
        return $r;
    }
    public function alpha2num($a)
    { // @author: Theriault
        $r = 0;
        $l = strlen($a);
        for ($i = 0; $i < $l; $i++) {
            $r += pow(26, $i) * (ord($a[$l - $i - 1]) - 0x40);
        }
        return $r - 1;
    }

    public function reIndexArray($arr, $startAt = 0)
    {
        // @author: Peter Bailey
        return (0 == $startAt)
        ? array_values($arr)
        : array_combine(range($startAt, count($arr) + ($startAt - 1)), array_values($arr));
    }

    public function arrayLongestItem($arr)
    {if (!empty($arr)) {
        return max($this->arrayItemsStrlen($arr));
    }
        return 0;
    }

    public function arrayLongestKey($arr)
    {if (!empty($arr)) {
        return max($this->arrayItemsStrlen(array_keys($arr)));
    }
        return 0;
    }

    public function arrayItemsStrlen($arr)
    {
        return array_map('strlen', $arr);
    }
}
