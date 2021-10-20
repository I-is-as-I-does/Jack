<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */

namespace SSITU\Jack\Interfaces;
interface Arrays_i {
public static function unsetNestedColumn(array $arr, mixed $columnKey);
public static function sortNestedByKey(array $arr, mixed $key);
public static function sortByKey(array $arr, mixed $key,  $order = 4);
public static function emptyItmsKeys(array $arr);
public static function filterDupeAndEmptyItms(array $arr);
public static function filterEmptyItms(array $arr);
public static function filterNonEmptyItms(array $arr);
public static function allItmsAreEmpty(array $arr);
public static function noItmsAreEmpty(array $arr);
public static function countEmptyItms(array $arr);
public static function allItemsAreInt(array $arr);
public static function allItemsAreString(array $arr);
public static function merge(array $originValues, array $newValues);
public static function flatten(mixed $itm, array $out = array (), mixed $key = '');
public static function reIndex(array $arr, int $startAt = 0);
public static function longestItm(array $arr);
public static function longestKey(array $arr);
public static function strlenItms(array $arr);
public static function highestKey(array $arr);
public static function highestIntKey(array $arr);
}