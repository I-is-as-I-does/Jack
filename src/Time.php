<?php
/* This file is part of Jacks | ExoProject | (c) 2021 I-is-as-I-does | MIT License */
namespace ExoProject\Jacks;

class Time implements Time_i
{
    public static function stamp($format = "Y-m-d H:i:s \G\M\TO")
    {
        return date($format);
    }

    public static function addTime($date, $interval, $format = "Y-m-d H:i:s \G\M\TO")
    {
        $date = date_create($date);
        date_add($date, date_interval_create_from_date_string($interval));
        return date_format($date, $format);
    }

    public static function isExpired($givendate, $maxdate)
    {
        $givendate = new \DateTime($givendate);
        $maxdate = new \DateTime($maxdate);
        if ($givendate < $maxdate) {
            return false;
        }
        return true;
    }

    public static function getInterval($origin, $target = null, $format = '%a')
    { //@doc: default format is: days
        if (empty($target)) {
            $target = self::stamp();
        }
        $target = date_create($target);
        $origin = date_create($origin);
        $interval = $origin->diff($target);
        $interval = $interval->format($format);
        return (int)$interval;
    }

    public static function isValidTimezone($timezoneId)
    {
        try {
            new \DateTimeZone($timezoneId);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }
}
