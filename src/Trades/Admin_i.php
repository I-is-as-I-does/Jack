<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */

namespace SSITU\Jack\Trades;

interface Admin_i
{
    public function bestHashCost($timeTarget = 0.05, $cost = 8, $algo = '2y');
    public function serverInfos();
    public function phpInfo();

}
