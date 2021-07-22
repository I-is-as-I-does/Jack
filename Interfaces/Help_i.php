<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */
namespace SSITU\Jack\Interfaces;
interface Help_i {
public static function isValidHexColor(string $hexCode);
public static function resolveHexColor(string $hexCode);
public static function filterBool(mixed $var);
public static function filterValue(mixed $var,  $filter = 513);
public static function intLen(int $int);
public static function UpCamelCase(string $string);
public static function isHTML(string $string);
public static function isPostvInt(mixed $value);
public static function isValidPattern(string $pattern);
public static function boolify(mixed $value);
public static function num2alpha(int $n);
public static function alpha2num(string $a);
public static function intIsInRange(string|int $int, string|int $min, string|int $max);
}