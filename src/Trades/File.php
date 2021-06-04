<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */
namespace SSITU\Jack\Trades;

class File implements File_i
{
    public function write($data, $path, $formatRslt = false)
    {
        $write = false;
        if (is_writable(dirname($path))) {
            $write = file_put_contents($path, $data, LOCK_EX);
        }
        if (!$formatRslt) {
            return $write;
        }
        return [$this->getRsltKeyword($write) => $path];
    }

    public function buffrInclude($path)
    { //@doc !if vars inside content, be aware that they will not be defined >here<
        if (file_exists($path)) {
            ob_start();
            include $path;
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

    public function reqTrailingSlash($dirPath)
    {
        return trim($dirPath, ' \n\r\t\v\0/\\') . '/';
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

    public function saveJson($data, $path, $formatRslt = false)
    {
        $json = json_encode($data, JSON_PRETTY_PRINT);
        return $this->write($json, $path, $formatRslt);
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

    public function moveDir($src, $dest)
    {
        if (!is_dir($src) || $src === $dest) {
            return false;
        }
        if (!is_dir(dirname($dest))) {
            mkdir(dirname($dest), 0777, true);
        }
        return rename($src, $dest);
    }

    public function recursiveCopy($src, $dest, $excl = [])
    {
        try {
            $dir = opendir($src);
            @mkdir($dest);
            $errlog = [];
            while ($file = readdir($dir)) {
                if (($file != '.') && ($file != '..') && (empty($excl) || !in_array($file, $excl))) {
                    if (is_dir($src . '/' . $file)) {
                        $run = $this->recursiveCopy($src . '/' . $file, $dest . '/' . $file);
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

    public function recursiveDelete($dirPath)
    {
        try {
            if (!empty($dirPath) && is_dir($dirPath)) {
                $dirObj = new \RecursiveDirectoryIterator($dirPath, \RecursiveDirectoryIterator::SKIP_DOTS); //@doc: upper dirs not included, otherwise DISASTER HAPPENS
                $files = new \RecursiveIteratorIterator($dirObj, \RecursiveIteratorIterator::CHILD_FIRST);
                foreach ($files as $path) {
                    $path->isDir() && !$path->isLink() ? rmdir($path->getPathname()) : unlink($path->getPathname());
                }
                return true;
            }
            return ['err' => 'unvalid dir. path: ' . $dirPath];
        } catch (\Exception$e) {
            return ['err' => var_export($e, true)];
        }
    }

    public function copySrcToDest($src, $dest, $formatRslt = false)
    {
        $cop = false;
        if (file_exists($src) && is_dir(dirname($dest))) {
            $cop = copy($src, $dest);
        }
        if (!$formatRslt) {
            return $cop;
        }
        return [$this->getRsltKeyword($cop) => $dest];
    }

    public function getRsltKeyword($boolish)
    {
        if (!empty($boolish)) {
            return 'success';
        }
        return 'err';
    }

    public function recursiveGlob($base, $pattern, $flags = 0)
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
            $dirFiles = glob_recursive($dir, $pattern, $flags);
            $files = array_merge($files, $dirFiles);
        }

        return $files;
    }

}
