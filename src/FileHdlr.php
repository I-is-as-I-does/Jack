<?php
/* This file is part of Jacks | ExoProject | (c) 2021 I-is-as-I-does | MIT License */
namespace ExoProject\Jacks;

class FileHdlr implements FileHdlr_i
{
    private static function traceBack()
    {
        return debug_backtrace()[0]['file'];
    }

    public static function writeFile($target, $content, $lvl = 2)
    {
        $check = self::checkFilePath(dirname($path), $lvl);
        if ($check === false) {
            return false;
        }
        $write = file_put_contents($target, $content, LOCK_EX);
        if ($write === false) {
            AnomaliesHdlr::record($target.' write error', self::traceBack(), $lvl);
        }
        return $write;
    }

    public static function buffrInclude($path, $lvl = 2)
    { //@doc !if vars inside content, be aware that they would not be defined >here<
        $check = self::checkFilePath($path, $lvl);
        if ($check === false) {
            return false;
        }
        ob_start();
        include($path);
        return ob_get_clean();
    }

    public static function requireContents($path, $lvl = 2)
    {
        $check = self::checkFilePath($path, $lvl);
        if ($check === false) {
            return false;
        }
        $content = file_get_contents($path);
        if ($content === false) {
            AnomaliesHdlr::record($path.' file not readable', self::traceBack(), $lvl);
        }
        return $content;
    }

    public static function checkFilePath($path, $lvl = 3)
    {
        if (!file_exists($path)) {
            AnomaliesHdlr::record($path.' not found', self::traceBack(), $lvl);
            return false;
        }
        return true;
    }

    public static function getinikey($varnam, $path, $lvl = 2)
    {
        $check = self::checkFilePath($path, $lvl);
        if ($check === false) {
            return false;
        }
        $keys = parse_ini_file($path);
        if (array_key_exists($varnam, $keys)) {
            return $keys[$varnam];
        }
        return false;
    }

    public static function handleb64img($dataimg, $dest = false, $lvl = 3)
    {
        if (stripos($dataimg, 'data:image/png;base64,') === false) {
            AnomaliesHdlr::record('invalid base64 img', self::traceBack(), $lvl);
            return false;
        }
      
        $dataimg = str_replace('data:image/png;base64,', '', $dataimg);
        $dataimg = str_replace(' ', '+', $dataimg);
        $decdimg = base64_decode($dataimg);
      
        if ($dest === false) {
            // @doc: returns bin img; false if b64 data is not a valid image
            return imagecreatefromstring($decdimg);
        }

        return self::writeFile($dest, $decdimg, $lvl);
    }

    public static function fileExt($file)
    {
        return strtolower(pathinfo($file, PATHINFO_EXTENSION));
    }

    public static function readJson($path, $lvl = 2)
    {
        $content = self::requireContents($path, $lvl);
        if ($content !== false) {
            $content = json_decode($content, true);
            if ($content !== null) {
                return $content;
            }
            AnomaliesHdlr::record($path.' seems to be unvalid json', self::traceBack(), $lvl);
        }
        return [];
    }

    public static function saveJson($data, $path, $lvl = 2)
    {
        $json = json_encode($data, JSON_PRETTY_PRINT);
        return self::writeFile($path, $json, $lvl);
    }

    public static function testReadWrite($filesOrfolders)
    {
        $rslt = [];
        foreach ($filesOrfolders as $filesOrfolder) {
            $state = 'fail';
            if (is_writable($filesOrfolder)) {
                $state = 'pass';
            }
            $rslt[] = $state.': '.$filesOrfolder;
        }
        return $rslt;
    }
}
