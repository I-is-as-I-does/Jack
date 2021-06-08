<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */
namespace SSITU\Jack\Trades;

interface Help_i
{
    public function UpCamelCase($string);
    public function num2alpha($n);
    public function alpha2num($a);
    public function isPostvInt($value);
    public function boolify($value);
    public function isValidPattern($pattern);
    public function isAlive($url);
    public function getSubDomain($noWWW = true);
    public function getRsltKeyword($boolish);
    public function isHTML($string);

}
