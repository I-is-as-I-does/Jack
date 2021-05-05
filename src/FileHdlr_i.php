<?php
/* This file is part of Jacks | ExoProject | (c) 2021 I-is-as-I-does | MIT License */
namespace ExoProject\Jacks;

interface FileHdlr_i
{
    public static function writeFile($target, $content, $lvl = 2);
    public static function buffrInclude($path, $lvl = 2);
    public static function requireContents($path, $lvl = 2);
    public static function checkFilePath($path, $lvl = 3);
    public static function getinikey($varnam, $path, $lvl = 2);
    public static function handleb64img($dataimg, $dest = false, $lvl = 3);
    public static function fileExt($file);
    public static function readJson($path, $lvl = 2);
    public static function saveJson($data, $path, $lvl = 2);
    public static function testReadWrite($filesOrfolders);
}
