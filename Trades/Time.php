<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */
namespace SSITU\Jack;

class Time
{

    public static function isoStamp()
    {
        return date("c");
    }

    public static function stamp($format = "Y-m-d H:i:s \G\M\TO")
    {
        return date($format);
    }

    public static function subTime($date, $interval, $format = "c")
    {
        $date = date_create($date);
        date_sub($date, date_interval_create_from_date_string($interval));
        return date_format($date, $format);
    }

    public static function addTime($date, $interval, $format = "c")
    {
        $date = date_create($date);
        date_add($date, date_interval_create_from_date_string($interval));
        return date_format($date, $format);
    }

    public static function isValidDate($date)
    {    date('Y-m-d',$date);
        return !empty(strtotime($date));
    }

    public static function dateObj($date)
    {
        try {
            $dateObj = date_create($date);
        }catch (\Exception$e) {
            return false;
        }
        return $dateObj;
    }

    public static function isExpired($givendate, $maxdate)
    {
        try {
            $givendate = date_create($givendate);
            $maxdate = date_create($maxdate);
            if ($givendate < $maxdate) {
                return false;
            }
            return true;
        } catch (\Exception$e) {
            return null;
        }
    }

    public static function isInInterval($date, $tolerance, $unit = "minutes")
    {
        $lapse = $tolerance . ' ' . $unit;
        $minDate = strtotime($date . ' - ' . $lapse);
        if($minDate === false){
            return null;
            //@doc: invalid tolerance and/or unit
        }
        $maxDate = strtotime($date . ' + ' . $lapse);
        $currDate = strtotime("now");
        return ($currDate < $maxDate && $currDate > $minDate);
    }

    public static function isInRange($date, $minDate, $maxDate = "now")
    {
        try {
            $maxDate = date_create($maxDate);
            $minDate = date_create($minDate);
            $date = date_create($date);
            if ($date < $maxDate && $date > $minDate) {
                return true;
            }
            return false;

        } catch (\Exception$e) {
            return null;
        }

    }

    public static function isFuture($date)
    {
        try {
            $date = date_create($date);
            if ($date > date_create()) {
                return true;
            }

            return false;
        } catch (\Exception$e) {
            return null;
        }
    }

    public static function convertEngToFormat($unit)
    {
        $unit = strtolower($unit);
        if (substr($unit, -1) == 's') {
            $unit = substr($unit, 0, -1);
        }
        if (in_array($unit, ['min', 'mn'])) {
            $unit = 'minute';
        } elseif ($unit == 'sec') {
            $unit = 'second';
        }

        $formatMap = [
            'year' => '%y',
            'month' => '%m',
            'day' => '%d',
            'hour' => '%h',
            'minute' => '%i',
            'second' => '%s'];
        if (array_key_exists($unit, $formatMap)) {
            return $formatMap[$unit];
        }
        return false;
    }

    public static function countRemainingTime($startDate, $count, $unit = 'day')
    {
        $format = self::convertEngToFormat($unit);
        if ($format === false) {
            return false;
        }
        $startDate = date_create($startDate);
        $lapse = date_interval_create_from_date_string($count . ' ' . $unit);
        $targetDate = date_add($startDate, $lapse);
        $now = date_create();
        return self::relativeInterval($now, $targetDate, $format);
    }

    public static function relativeInterval($originDate, $targetDate, $format)
    {
        //@doc: here, dates MUST be date objects
        $interval = date_diff($originDate, $targetDate);
        return (int) date_interval_format($interval, '%r'.$format);
    }

    public static function getInterval($origin, $target = null, $format = '%a')
    { //@doc: default format is: days
        if (empty($target)) {
            $target = self::isoStamp();
        }
        $target = date_create($target);
        $origin = date_create($origin);
        return self::relativeInterval($origin, $target, $format);
    }

    public static function isValidTimezone($timezoneId)
    {
        try {
            new \DateTimeZone($timezoneId);
        } catch (\Exception$e) {
            return false;
        }
        return true;
    }

    public static function timezonesList()
    {
        return \DateTimeZone::listIdentifiers(\DateTimeZone::ALL);
    }

}
