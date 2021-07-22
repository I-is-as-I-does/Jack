<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */
namespace SSITU\Jack\Interfaces;
interface Token_i {
public static function timeBased();
public static function sha40char();
public static function getSecrets(string $token, array $eligiblechars);
public static function withSecret(string $secretchar, array $pool, int $tokenlength);
public static function b64basic(int $bytes = 64);
public static function hexBytes(int $bytes = 32);
}