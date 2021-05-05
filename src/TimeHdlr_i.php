<?php
/* This file is part of Jacks | ExoProject | (c) 2021 I-is-as-I-does | MIT License */
namespace ExoProject\Jacks;

interface TimeHdlr_i
{
    public static function timestamp($format = "Y-m-d H:i:s \G\M\TO");
    public static function addTime($date, $interval, $format = "Y-m-d H:i:s \G\M\TO");
    public static function isExpired($givendate, $maxdate);
    public static function isOld($origin, $target, $limit = 30, $format = '%a');
    public static function isValidTimezone($timezoneId);
}
