<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */
namespace SSITU\Jack\Interfaces;

interface Arrays_i
{

    public function allItemsAreInt($array);
    public function allItemsAreString($array);
    public function merge($originValues, $newValues);
    public function reIndex($arr, $startAt = 0);

    public function longestItem($arr);
    public function longestKey($arr);
    public function itemsStrlen($arr);

    public function flatten($itm, $out = [], $key = '');



}