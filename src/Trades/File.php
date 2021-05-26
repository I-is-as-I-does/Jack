<?php
/* This file is part of JackTrades | (c) 2021 I-is-as-I-does */
namespace SSITU\JackTrades\Trades;

class File implements File_i
{
    public function write($data, $path)
    {
        if (is_writable(dirname($path))) {
            return file_put_contents($path, $data, LOCK_EX);
        }
        return false;
    }

    public function buffrInclude($path)
    { //@doc !if vars inside content, be aware that they will not be defined >here<
        if (file_exists($path)) {
            ob_start();
            include($path);
            return ob_get_clean();
        }
        return false;
    }

    public function getContents($path)
    {
        if (file_exists($path)) {
            return file_get_contents($path);
        }
        return false;
    }

    public function readIni($path)
    {
        if (file_exists($path)) {
            return parse_ini_file($path);
        }
        return false;
    }

    public function handleb64img($dataimg, $path = false)
    {
        if (stripos($dataimg, 'data:image/png;base64,') === false) {
            return false;
        }
      
        $dataimg = str_replace('data:image/png;base64,', '', $dataimg);
        $dataimg = str_replace(' ', '+', $dataimg);
        $decdimg = base64_decode($dataimg);
      
        if ($path === false) {
            // @doc: returns bin img; false if b64 data is not a valid image
            return imagecreatefromstring($decdimg);
        }
        //@doc: $path should be .png
        return $this->write($decdimg, $path);
    }

    public function getExt($path)
    {
        return strtolower(pathinfo($path, PATHINFO_EXTENSION));
    }

    public function readJson($path)
    {
        $content = $this->getContents($path);
        if ($content !== false) {
            $content = json_decode($content, true);
            if (!empty($content)) {
                return $content;
            }
        }
        return [];
    }

    public function saveJson($data, $path)
    {
        $json = json_encode($data, JSON_PRETTY_PRINT);
        return $this->write($json, $path);
    }

    public function testReadWrite($paths)
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
}
