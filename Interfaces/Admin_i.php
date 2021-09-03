<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */

namespace SSITU\Jack\Interfaces;
interface Admin_i {
public static function getAppFolder();
public static function benchmark(callable $callback, array $argm = array ());
public static function bestHashCost(int|float $timeTarget = 0.05, int $cost = 8,  $algo = '2y');
public static function serverInfos();
public static function phpInfo();
public static function hashAdminKey(string $adminKey);
}