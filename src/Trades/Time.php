<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */
namespace SSITU\Jack\Trades;

class Time implements Time_i
{

    public function isoStamp(){
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
        $givendate = new \DateTime($givendate);
        $maxdate = new \DateTime($maxdate);
        if ($givendate < $maxdate) {
            return false;
        }
        return true;
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

    public function getRemainingTime($startDate, $count, $unit = 'day')
    {
        $format = $this->convertEngToFormat($unit);
        if($format === false){
            return false;
        }
        $startDate = date_create($startDate);
        $lapse = date_interval_create_from_date_string($count . ' ' . $unit);
        $targetDate = date_add($startDate, $lapse);
        $now = date_create();
        $diff = date_diff($now, $targetDate);
        $output = date_interval_format($diff, $format);
        if ($now > $targetDate) {
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
        $interval = $origin->diff($target);
        $interval = $interval->format($format);
        return (int) $interval;
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

    
    public function timezonesList(){
        return \DateTimeZone::listIdentifiers(\DateTimeZone::ALL);
    }

}
