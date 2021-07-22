<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */
namespace SSITU\Jack\Interfaces;
interface Time_i {
public static function isoStamp();
public static function stamp(string $format = 'Y-m-d H:i:s \\G\\M\\TO');
public static function subTime(string $date, string $interval, string $format = 'c');
public static function addTime(string $date, string $interval, string $format = 'c');
public static function isValidDate(string $date);
public static function dateObj(string $date);
public static function isExpired(string $givendate, string $maxdate);
public static function isInInterval(string $date, string|int $tolerance, string $unit = 'minutes');
public static function isInRange(string $date, string $minDate, string $maxDate = 'now');
public static function isFuture(string $date);
public static function convertEngToFormat(string $unit);
public static function countRemainingTime(string $startDate, string|int $count, string $unit = 'day');
public static function relativeInterval(object $originDate, object $targetDate, string $format);
public static function getInterval(string $origin, ?string $target = NULL, string $format = '%a');
public static function isValidTimezone(string $timezoneId);
public static function timezonesList();
}