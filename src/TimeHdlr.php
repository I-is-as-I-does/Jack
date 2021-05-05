<?php
/* This file is part of Jacks | ExoProject | (c) 2021 I-is-as-I-does | MIT License */
namespace ExoProject\Jacks;

class TimeHdlr implements TimeHdlr_i
{
    public static function timestamp($format = "Y-m-d H:i:s \G\M\TO")
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

    public static function isOld($origin, $target, $limit = 30, $format = '%a')
    { //@doc: default format is: days
        if (!$target) {
            $target = self::timestamp();
        }
        $target = date_create($target);
        $origin = date_create($origin);
        $interval = $origin->diff($target);
        $interval = $interval->format($format);
        if ((int)$interval > $limit) {
            return true;
        }
        return false;
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

