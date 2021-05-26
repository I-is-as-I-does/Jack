<?php
/* This file is part of JackTrades | (c) 2021 I-is-as-I-does */
namespace SSITU\JackTrades\Trades;

interface Token_i
{
    public function timeBased();
    public function sha40char();
    public function getSecrets($token, $eligiblechars);
    public function withSecret($secretchar, $pool, $tokenlength);
    public function b64basic($bytes = 64);
}
