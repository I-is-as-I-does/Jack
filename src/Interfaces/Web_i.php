<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */

namespace SSITU\Jack\Interfaces;

interface Web_i
{
    public function getProtocol();
    public function isAlive($url);
    public function getSubDomain($noWWW = true);
    public function httpPost($url, $data);
}
