<?php
/* This file is part of JackTrades | SSITU | (c) 2021 I-is-as-I-does | MIT License */

namespace SSITU\JackTrades\Trades;

class Admin implements Admin_i
{

    public function bestHashCost($timeTarget = 0.05, $cost = 8, $algo = PASSWORD_DEFAULT)
    {
/** @source: www.php.net/manual
 * This code will benchmark your server to determine how high of a cost you can
 * afford. You want to set the highest cost that you can without slowing down
 * you server too much. 8-10 is a good baseline, and more is good if your servers
 * are fast enough. By default, the code aims for ≤ 50 milliseconds stretching time,
 * which is a good baseline for systems handling interactive logins.
 */
        do {
            $cost++;
            $start = microtime(true);
            password_hash("test", $algo, ["cost" => $cost]);
            $end = microtime(true);
        } while (($end - $start) < $timeTarget);
  
        return "Appropriate Cost Found: "  . $cost;
    }

    public function isAlive($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            $headers = @get_headers($url);
            $resp_code = substr($headers[0], 9, 3);
            if (intval($resp_code) > 0 && intval($resp_code) < 400) {
                return true;
            }
        }
        return false;
    }


    public function getSubDomain($noWWW = true)
    {
        $splithost = explode('.', $_SERVER['HTTP_HOST']);
        $subdomain = $splithost[0];
        if ($noWWW && $subdomain === 'www') {
            $subdomain = $splithost[1];
        }
        return $subdomain;
    }
    
    public function serverInfos()
    {
        phpinfo(32);
    }

    public function phpInfo()
    {
        phpinfo();
    }

    public function getDirSize($dir)
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

    public function getAvailableSpace($dir, $maxGB) //@doc: $dir must be specified with __DIR__
    {
        $dirSize = $this->getDirSize($dir);
        $sizeInGb = $dirSize/(1024*1024*1024);
        $perct = ($sizeInGb*100)/$max;
        return round(100-$perct, 2).' %';
    }
}
