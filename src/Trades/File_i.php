<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */

namespace SSITU\Jack\Trades;

interface File_i
{
  
    public function copySrcToDest($src, $dest, $formatRslt = false);
    public function write($data, $path);
    public function buffrInclude($path);
    public function getContents($path);
    public function readIni($path);
    public function handleb64img($dataimg, $path = false);
    public function getExt($path);
    public function reqTrailingSlash($dirPath);
    public function readJson($path);
    public function saveJson($data, $path);
    public function testReadWrite($paths);
    public function getRsltKeyword($boolish);
    public function recursiveGlob($base, $pattern, $flags = 0);
    public function recursiveCopy($src, $dest, $excl = []);
    public function recursiveDelete($dirPath);
}
