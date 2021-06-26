<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */

namespace SSITU\Jack\Trades;

interface Web_i
{
    public function redirect($url);
    public function getProtocol();
    public function isAlive($url);
    public function getSubDomain($noWWW = true);
    public function httpPost($url, $data);
    public function b64url_decode($data);
    public function b64url_encode($data);
}
