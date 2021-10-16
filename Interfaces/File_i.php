<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */

namespace SSITU\Jack\Interfaces;
interface File_i {
    
    public static function dirExists(string $path, bool $create = false);
    public static function backToSlash(string $path);
public static function recursiveMkdir(string $dir);
public static function writeAppend(mixed $data, string $path);
public static function write(mixed $data, string $path, bool $formatRslt = false);
public static function buffrInclude(string $path, mixed $v_ = NULL);
public static function getContents(string $path);
public static function readIni(string $path);
public static function getExt(string $path);
public static function reqTrailingSlash(string $path);
public static function prettyJsonEncode(mixed $data);
public static function readJson(string $path, bool $asArray = true, bool $strictMode = false);
public static function saveJson(mixed $data, string $path, bool $formatRslt = false);
public static function testReadWrite(array $paths);
public static function moveFileObj(string $src, string $dest);
public static function recursiveCopy(string $src, string $dest, array $excl = array ());
public static function patternDelete(string $globPattern, mixed $flag = 0);
public static function recursiveDelete(string $dirPath, bool $parentDirToo = false);
public static function copySrcToDest(string $src, string $dest, bool $formatRslt = false);
public static function recursiveGlob(string $base, string $pattern, mixed $flags = 0);
public static function countInodes(string $path);
public static function getDirSize(string $dir);
public static function getOccupiedSpace(string $dir);
public static function getAvailableSpace(string $dir, int $maxGB, bool $prct = true);
public static function getRsltKeyword(mixed $boolish, string $success = 'success', string $error = 'err');
}