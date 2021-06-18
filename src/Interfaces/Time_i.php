<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */
namespace SSITU\Jack\Interfaces;

interface Time_i
{
    public function isoStamp();
    public function stamp($format = "Y-m-d H:i:s \G\M\TO");
    public function subTime($date, $interval, $format = "c");
    public function addTime($date, $interval, $format = "Y-m-d H:i:s \G\M\TO");
    public function isExpired($givendate, $maxdate);
    public function getInterval($origin, $target, $format = '%a');   
    public function getRemainingTime($startDate, $count, $unit = 'day');
    public function convertEngToFormat($unit);
    public function isValidTimezone($timezoneId);
    public function timezonesList();
    public function isFuture($date);
}