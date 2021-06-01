<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */
namespace SSITU\Jack\Trades;

interface Time_i
{
    public function stamp($format = "Y-m-d H:i:s \G\M\TO");
    public function addTime($date, $interval, $format = "Y-m-d H:i:s \G\M\TO");
    public function isExpired($givendate, $maxdate);
    public function getInterval($origin, $target, $format = '%a');
    public function isValidTimezone($timezoneId);
}
