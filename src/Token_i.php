<?php 
/* This file is part of Jacks | ExoProject | (c) 2021 I-is-as-I-does | MIT License */
namespace ExoProject\Jacks;

interface Token_i
{
    public static function timeBased();
    public static function sha40char();
    public static function getSecrets($token, $eligiblechars);
    public static function withSecret($secretchar, $pool, $tokenlength);
    public static function b64basic($bytesnbr = 64);
}