<?php
/* This file is part of Jacks | ExoProject | (c) 2021 I-is-as-I-does | MIT License */
namespace ExoProject\Jacks;

interface File_i
{
    public static function write($target, $content);
    public static function buffrInclude($path);
    public static function requireContents($path);
    public static function checkPath($path);
    public static function getinival($path, $key);
    public static function handleb64img($dataimg, $dest = false);
    public static function ext($file);
    public static function readJson($path);
    public static function saveJson($data, $path);
    public static function testReadWrite($filesOrfolders);
}
