<?php
/* This file is part of JackTrades | SSITU | (c) 2021 I-is-as-I-does | MIT License */

namespace SSITU\JackTrades\Trades;

interface Admin_i
{
    
    public function isAlive($url);
    public function getSubDomain($noWWW = true);
    
    public function serverInfos();
    public function phpInfo();

    public function getDirSize($dir);
    public function getAvailableSpace($dir, $maxGB);
}
