<?php
/* This file is part of Jacks | ExoProject | (c) 2021 I-is-as-I-does | MIT License */
namespace ExoProject\Jacks;

class File implements File_i
{
    /* @doc: You can use ExoProject "Houston" error handler:
            $ composer require exoproject/houston
            $errorHdlr_class = 'ExoProject\Houston\Houston';
        or edit to use your own; 
        or set to false to deactivate error handling.
    */   
    protected $errorHdlr_class = false; 

    protected function callErrHandlr($errMsg){
        if (!empty(self::$errorHdlr_class)) {
            $errhdlr = self::$errorHdlr_class;
            $report = ['data'=>$errMsg, 'origin'=>debug_backtrace()[0]['file']];
            //@doc: add a timestamp to report if your error handler does not add it on its own
            new $errhdlr($report);
        }
    }

    public static function write($target, $content)
    {
        $check = self::checkPath(dirname($path));
        if ($check === false) {
            return false;
        }
        $write = file_put_contents($target, $content, LOCK_EX);
        if ($write === false) {
           self::callErrHandlr($target.' write error');
           return false;
        }
        return $write;
    }

    public static function buffrInclude($path)
    { //@doc !if vars inside content, be aware that they will not be defined >here<
        $check = self::checkPath($path);
        if ($check === false) {
            return false;
        }
        ob_start();
        include($path);
        return ob_get_clean();
    }

    public static function requireContents($path)
    {
        $check = self::checkPath($path);
        if ($check === false) {
            return false;
        }
        $content = file_get_contents($path);
        if ($content === false) {
            self::callErrHandlr($path.' file not readable');
        }
        return $content;
    }

    public static function checkPath($path)
    {
        if (!file_exists($path)) {
            self::callErrHandlr($path.' not found');
            return false;
        }
        return true;
    }

    public static function getinival($path, $key)
    {
        $check = self::checkPath($path);
        if ($check === false) {
            return false;
        }
        $content = parse_ini_file($path);
        if (array_key_exists($key, $content)) {
            return $content[$key];
        }
        return false;
    }

    public static function handleb64img($dataimg, $dest = false)
    {
        if (stripos($dataimg, 'data:image/png;base64,') === false) {
            self::callErrHandlr('invalid base64 img');
            return false;
        }
      
        $dataimg = str_replace('data:image/png;base64,', '', $dataimg);
        $dataimg = str_replace(' ', '+', $dataimg);
        $decdimg = base64_decode($dataimg);
      
        if ($dest === false) {
            // @doc: returns bin img; false if b64 data is not a valid image
            return imagecreatefromstring($decdimg);
        }

        return self::write($dest, $decdimg);
    }

    public static function ext($file)
    {
        return strtolower(pathinfo($file, PATHINFO_EXTENSION));
    }

    public static function readJson($path)
    {
        $content = self::requireContents($path);
        if ($content !== false) {
            $content = json_decode($content, true);
            if ($content !== null) {
                return $content;
            }
            self::callErrHandlr($path.' seems to be unvalid json');
        }
        return [];
    }

    public static function saveJson($data, $path)
    {
        $json = json_encode($data, JSON_PRETTY_PRINT);
        return self::write($path, $json);
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
