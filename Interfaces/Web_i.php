<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */

namespace SSITU\Jack\Interfaces;
interface Web_i {
public static function redirect(string $url);
public static function addQueries(string $pageUrl, array $queries);
public static function getProtocol();
public static function isAlive(string $url);
public static function httpPost(string $url, array $data);
public static function b64url_encode(string $data);
public static function b64url_decode(string $data);
public static function extractSubDomain(?string $url = NULL, bool $exlude_www = true);
public static function setCookie(bool $startSession = true, bool $httponly = true, string $samesite = 'None', int $lifetime = 0, string $path = '/', ?bool $secure = null, ?string $domain = null);

}