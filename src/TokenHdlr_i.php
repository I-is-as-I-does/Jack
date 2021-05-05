<?php 
/* This file is part of Jacks | ExoProject | (c) 2021 I-is-as-I-does | MIT License */
namespace ExoProject\Jacks;

interface TokenHdlr_i
{
    public static function timeBasedToken();
    public static function getSecretsFromToken($token, $eligiblechars);
    public static function tokenWithSecret($secretchar, $pool, $tokenlength);
    public static function boolify($val);
    public static function nonce($bytesnbr = 64);
}