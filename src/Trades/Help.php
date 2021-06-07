<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */
namespace SSITU\Jack\Trades;

class Help implements Help_i
{

    public function isHTML($string){
        if($string != strip_tags($string)){
         return true;
        }
         return false;
       }

    public function isPostvInt($value)
    { //  @doc works even if $value is a string-integer
        return ((is_int($value) || ctype_digit($value)) && (int) $value > 0);
    }

    public function isValidPattern($pattern)
    {
        $pattern = '/' . trim($pattern, '/') . '/';
        if (@preg_match($pattern, null) === false) {
            return false;
        }
        return true;
    }

    public function boolify($value)
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    public function num2alpha($n)
    { // @author: Theriault
        $r = '';
        for ($i = 1; $n >= 0 && $i < 10; $i++) {
            $r = chr(0x41 + ($n % pow(26, $i) / pow(26, $i - 1))) . $r;
            $n -= pow(26, $i);
        }
        return $r;
    }
    public function alpha2num($a)
    { // @author: Theriault
        $r = 0;
        $l = strlen($a);
        for ($i = 0; $i < $l; $i++) {
            $r += pow(26, $i) * (ord($a[$l - $i - 1]) - 0x40);
        }
        return $r - 1;
    }
    public function getRsltKeyword($boolish)
    {
        if (!empty($boolish)) {
            return 'success';
        }
        return 'err';
    }

    public function isAlive($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            $headers = @get_headers($url);
            $resp_code = substr($headers[0], 9, 3);
            if (intval($resp_code) > 0 && intval($resp_code) < 400) {
                return true;
            }
        }
        return false;
    }

    public function getSubDomain($noWWW = true)
    {
        $splithost = explode('.', $_SERVER['HTTP_HOST']);
        $subdomain = $splithost[0];
        if ($noWWW && $subdomain === 'www') {
            $subdomain = $splithost[1];
        }
        return $subdomain;
    }
}
