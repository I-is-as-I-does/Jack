<?php
/* This file is part of JackTrades | (c) 2021 I-is-as-I-does */
namespace SSITU\JackTrades\Trades;

interface Help_i
{
    public function num2alpha($n);
    public function alpha2num($a);

    public function isPostvInt($value);
    public function boolify($value);
    public function isValidPattern($pattern);

    public function updateArray($basevalues, $updatevalues);
    public function reIndexArray($arr, $startAt = 0);

    public function arrayLongestItem($arr);
    public function arrayLongestKey($arr);
    public function arrayItemsStrlen($arr);

    public function flattenOutput($itm, $out = [], $key = '');
}
