<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */
namespace SSITU\Jack\Trades;

interface Token_i
{
    public function timeBased();
    public function sha40char();
    public function getSecrets($token, $eligiblechars);
    public function withSecret($secretchar, $pool, $tokenlength);
    public function b64basic($bytes = 64);
}
