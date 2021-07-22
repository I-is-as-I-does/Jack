<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */
namespace SSITU\Jack\Interfaces;
interface Random_i {
public static function boolean();
public static function digit();
public static function speChar(array|string $speChars = '*&!@%^#$');
public static function multLetters(int $count, string $case = 'random');
public static function letter(string $case = 'random');
public static function mix(int $bytes = 32, array|string $speChars = '*&!@%^#$');
}