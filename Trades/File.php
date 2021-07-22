<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */
namespace SSITU\Jack;

class File
{

    public static function recursiveMkdir($dir)
    {
        if (!is_dir($dir)) {
            return @mkdir($dir, 0777, true);
        }
        return true;
    }

    public static function write($data, $path, $formatRslt = false)
    {
        $write = false;
        if (is_writable(dirname($path))) {
            $write = file_put_contents($path, $data, LOCK_EX);
        }
        if (!$formatRslt) {
            return $write;
        }
        return [self::getRsltKeyword($cop) => $dest];

    }

    public static function buffrInclude($path, $v_ = [])
    {
        if (file_exists($path)) {
            ob_start();
            include $path;
            return ob_get_clean();
        }
        return false;
    }

    public static function getContents($path)
    {
        if (file_exists($path)) {
            return file_get_contents($path);
        }
        return false;
    }

    public static function readIni($path)
    {
        if (file_exists($path)) {
            return parse_ini_file($path);
        }
        return false;
    }

    public static function getExt($path)
    {
        return strtolower(pathinfo($path, PATHINFO_EXTENSION));
    }

    public static function reqTrailingSlash($dirPath)
    {
        return trim($dirPath, ' \n\r\t\v\0/\\') . '/';
    }

    public static function readJson($path, $asArray = true, $strictMode = false)
    {
        $content = self::getContents($path);
        if ($content !== false) {
            $content = json_decode($content, $asArray);
            if (!is_null($content)) {
                return $content;
            }
        }
        if ($strictMode) {
            return null;
        }
        return [];
    }

    public static function saveJson($data, $path, $formatRslt = false)
    {
        $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT);
        return self::write($json, $path, $formatRslt);
    }

    public static function testReadWrite($paths)
    {
        $rslt = [];
        foreach ($paths as $fileOrfolder) {
            $state = 'fail';
            if (is_writable($fileOrfolder)) {
                $state = 'pass';
            }
            $rslt[$fileOrfolder] = $state;
        }
        return $rslt;
    }


    public static function moveFileObj($src, $dest)
    {
        if (!file_exists($src) || $src === $dest) {
            return false;
        }
        if (!is_dir(dirname($dest))) {
            @mkdir(dirname($dest), 0777, true);
        }
        return @rename($src, $dest);
    }

    public static function recursiveCopy($src, $dest, $excl = [])
    {
        try {
            $dir = opendir($src);
            @mkdir($dest);
            $errlog = [];
            while ($file = readdir($dir)) {
                if (($file != '.') && ($file != '..') && (empty($excl) || !in_array($file, $excl))) {
                    if (is_dir($src . '/' . $file)) {
                        $run = self::recursiveCopy($src . '/' . $file, $dest . '/' . $file);
                    } else {
                        $run = copy($src . '/' . $file, $dest . '/' . $file);
                    }
                    if ($run !== true) {
                        $errlog[$file] = $run;
                    }
                }
            }
            closedir($dir);
            if (empty($errlog)) {
                return true;
            }
            return $errlog;
        } catch (\Exception$e) {
            return ['err' => var_export($e, true)];
        }
    }

    public static function patternDelete($globPattern, $flag = 0)
    {
        return array_map('unlink', glob($globPattern, $flag));
    }

    public static function recursiveDelete($dirPath)
    {
        try {
            if (!empty($dirPath) && is_dir($dirPath)) {
                $dirObj = new \RecursiveDirectoryIterator($dirPath, \RecursiveDirectoryIterator::SKIP_DOTS); //@doc: upper dirs not included, otherwise DISASTER HAPPENS
                $files = new \RecursiveIteratorIterator($dirObj, \RecursiveIteratorIterator::CHILD_FIRST);
                foreach ($files as $path) {
                    $path->isDir() && !$path->isLink() ? @rmdir($path->getPathname()) : @unlink($path->getPathname());
                }
                return true;
            }
            return ['err' => 'unvalid dir. path: ' . $dirPath];
        } catch (\Exception$e) {
            return ['err' => var_export($e, true)];
        }
    }

    public static function copySrcToDest($src, $dest, $formatRslt = false)
    {
        $cop = false;
        if (file_exists($src) && is_dir(dirname($dest))) {
            $cop = copy($src, $dest);
        }
        if (!$formatRslt) {
            return $cop;
        }
        return [self::getRsltKeyword($cop) => $dest];
    }

    public static function recursiveGlob($base, $pattern, $flags = 0)
    {
        $flags = $flags & ~GLOB_NOCHECK;

        if (substr($base, -1) !== DIRECTORY_SEPARATOR) {
            $base .= DIRECTORY_SEPARATOR;
        }

        $files = glob($base . $pattern, $flags);
        if (!is_array($files)) {
            $files = [];
        }

        $dirs = glob($base . '*', GLOB_ONLYDIR | GLOB_NOSORT | GLOB_MARK);
        if (!is_array($dirs)) {
            return $files;
        }

        foreach ($dirs as $dir) {
            $dirFiles = self::recursiveGlob($dir, $pattern, $flags);
            $files = array_merge($files, $dirFiles);
        }

        return $files;
    }

    public static function countInodes($path)
    { //@doc: beware, this can be very slow
        $objects = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path),
            \RecursiveIteratorIterator::SELF_FIRST
        );
        return iterator_count($objects);
    }

    public static function getDirSize($dir)
    { // @author: André Fiedler
        $dir = rtrim(str_replace('\\', '/', $dir), '/');

        if (is_dir($dir) === true) {
            $totalSize = 0;
            $os = strtoupper(substr(PHP_OS, 0, 3));

            // If on a Unix Host (Linux, Mac OS)
            if ($os !== 'WIN') {
                $io = popen('/usr/bin/du -sb ' . $dir, 'r');
                if ($io !== false) {
                    $totalSize = intval(fgets($io, 80));
                    pclose($io);
                    return $totalSize;
                }
            }
            // If on a Windows Host (WIN32, WINNT, Windows)
            if ($os === 'WIN' && extension_loaded('com_dotnet')) {
                $obj = new \COM('scripting.filesystemobject');
                if (is_object($obj)) {
                    $ref = $obj->getfolder($dir);
                    $totalSize = $ref->size;
                    $obj = null;
                    return $totalSize;
                }
            }
            // If System calls did't work, use slower PHP 5
            $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir));
            foreach ($files as $file) {
                $totalSize += $file->getSize();
            }
            return $totalSize;
        } elseif (is_file($dir) === true) {
            return filesize($dir);
        }
    }

//@doc: $dir must be specified with __DIR__
    public static function getOccupiedSpace($dir)
    {$dirSize = self::getDirSize($dir);
        $sizeInGb = $dirSize / (1024 * 1024 * 1024);
        return round($sizeInGb, 2);
    }

//@doc: $dir must be specified with __DIR__
    public static function getAvailableSpace($dir, $maxGB, $prct = true)
    {$sizeInGb = self::getOccupiedSpace($dir);
        if ($prct) {
            $prctRslt = ($sizeInGb * 100) / $maxGB;
            return round(100 - $prctRslt, 2);
        }
        return $maxGB - $sizeInGb;
    }

    public static function getRsltKeyword($boolish, $success = "success", $error = "err")
    {
        if (!empty($boolish)) {
            return $success;
        }
        return $error;
    }

}
