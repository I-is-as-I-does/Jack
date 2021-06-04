<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */

namespace SSITU\Jack\Trades;

interface Admin_i
{
    public function call($classObj, $subClassName, $subParam = []);
    public function bestHashCost($timeTarget = 0.05, $cost = 8, $algo = '2y');
    public function isAlive($url);
    public function getSubDomain($noWWW = true);
    public function serverInfos();
    public function phpInfo();
    public function countInodes($path);
    public function getDirSize($dir);
    public function getOccupiedSpace($dir);
    public function getAvailableSpace($dir, $maxGB, $prct = true);
}
