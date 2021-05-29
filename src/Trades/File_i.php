<?php

namespace SSITU\JackTrades\Trades;
interface File_i {
public function write($data, $path);
public function buffrInclude($path);
public function getContents($path);
public function readIni($path);
public function handleb64img($dataimg, $path = false);
public function getExt($path);
public function readJson($path);
public function saveJson($data, $path);
public function testReadWrite($paths);
public function getRsltKeyword($boolish);
}