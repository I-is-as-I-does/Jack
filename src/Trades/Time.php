<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */
namespace SSITU\Jack\Trades;

class Time implements Time_i
{

    public function isoStamp()
    {
        return date("c");
    }

    public function stamp($format = "Y-m-d H:i:s \G\M\TO")
    {
        return date($format);
    }

    public function subTime($date, $interval, $format = "c")
    {
        $date = date_create($date);
        date_sub($date, date_interval_create_from_date_string($interval));
        return date_format($date, $format);
    }

    public function addTime($date, $interval, $format = "c")
    {
        $date = date_create($date);
        date_add($date, date_interval_create_from_date_string($interval));
        return date_format($date, $format);
    }

    public function isExpired($givendate, $maxdate)
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

    public function isInRange($date, $min, $max = "now")
    {
        try {
       $max = date_create($max);
       $min = date_create($min);
       $date = date_create($date);
            if($date < $max && $date > $min){
                return true;
            }
            return false;

    } catch (\Exception$e) {
        return null;
    }
      
    }

    public function isFuture($date)
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

    public function convertEngToFormat($unit)
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
        if (array_key_exist($unit, $formatMap)) {
            return $formatMap[$unit];
        }
        return false;
    }


    public function countRemainingTime($startDate, $count, $unit = 'day')
    {
        $format = $this->convertEngToFormat($unit);
        if ($format === false) {
            return false;
        }
        $startDate = date_create($startDate);
        $lapse = date_interval_create_from_date_string($count . ' ' . $unit);
        $targetDate = date_add($startDate, $lapse);
        $now = date_create();
        return $this->relativeInterval($now, $targetDate, $format);
    }

    public function relativeInterval($originDate, $targetDate, $format) 
    {
        //@doc: here, dates must be date objects
        $interval = date_diff($originDate, $targetDate);
        $output = (int)date_interval_format($interval, $format);
        if ($originDate > $targetDate) {
            return -$output;
        }
        return $output;
    }

    public function getInterval($origin, $target = null, $format = '%a')
    { //@doc: default format is: days
        if (empty($target)) {
            $target = $this->isoStamp();
        }
        $target = date_create($target);
        $origin = date_create($origin);
        return $this->relativeInterval($origin, $target, $format);
    }

    public function isValidTimezone($timezoneId)
    {
        try {
            new \DateTimeZone($timezoneId);
        } catch (\Exception$e) {
            return false;
        }
        return true;
    }

    public function timezonesList()
    {
        return \DateTimeZone::listIdentifiers(\DateTimeZone::ALL);
    }

}
