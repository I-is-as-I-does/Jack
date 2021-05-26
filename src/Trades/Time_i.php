<?php
/* This file is part of JackTrades | (c) 2021 I-is-as-I-does */
namespace SSITU\JackTrades\Trades;

interface Time_i
{
    public function stamp($format = "Y-m-d H:i:s \G\M\TO");
    public function addTime($date, $interval, $format = "Y-m-d H:i:s \G\M\TO");
    public function isExpired($givendate, $maxdate);
    public function getInterval($origin, $target, $format = '%a');
    public function isValidTimezone($timezoneId);
}
