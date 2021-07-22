<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */
namespace SSITU\Jack\Trades;

interface Help_i
{
    public function filterBool($var);
    public function filterValue($var, $filter = FILTER_SANITIZE_STRING);
    public function b64pad($value, $pad = '=');
    public function randomBool();
    public function randLetter($case = 'random');
    public function multRandLetters($count, $case = 'random');
    public function UpCamelCase($string);
    public function num2alpha($n);
    public function alpha2num($a);
    public function isPostvInt($value);
    public function boolify($value);
    public function isValidPattern($pattern);
    public function getRsltKeyword($boolish);
    public function isHTML($string);

}
