<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */
namespace SSITU\Jack\Trades;

use \SSITU\Jack\Interfaces\Help_i;


class Help implements Help_i
{

    public function filterBool($var)
    {
        $san = filter_var($var, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        if ($san === null) {
            return false;
        }
        return true;
    }

    public function filterValue($var, $filter = FILTER_SANITIZE_STRING)
    {
        $san = filter_var($var, $filter);
        if ($san == $var) {
            return true;
        }
        return false;
    }

    public function intlen($int){
       return $int !== 0 ? floor(log10($int) + 1) : 1; 
    }
 
    public function randomBool(){
        return (bool)random_int(0, 1);
    }

    public function randomDigit(){
        return random_int(0, 9);
    }

    public function randomSpeChar($speChars = '*&!@%^#$'){
        
       return $speChars[random_int(0, 7)];
    }
    
    public function multRandLetters($count, $case = 'random'){
        $out = '';   
        for($c = 0;$c < $count; $c++){
            $out .= $this->randLetter($case);
        }
        return $out;
    }
    
    public function randLetter($case = 'random') {
    $a_z = "abcdefghijklmnopqrstuvwxyz";
    $rand_letter = $a_z[random_int(0, 25)];
    if($case == 'random'){
        $case = $this->randomBool();
    }
    if($case == true || $case == 'upper'){
        return strtoupper($rand_letter);
    } 
    return $rand_letter;
  }

    public function UpCamelCase($string)
    {
        $splt = preg_split('/[^A-Za-z0-9]+|(?=[A-Z])/', $string);
        $splt = array_map('ucfirst', $splt);
        return implode('', $splt);
    }

    public function isHTML($string)
    {
        if ($string != strip_tags($string)) {
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

   
}
