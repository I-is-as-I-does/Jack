<?php
/* This file is part of Jacks | ExoProject | (c) 2021 I-is-as-I-does | MIT License */
namespace ExoProject\Jacks;

// @doc: in a dev env., you can also use:
// error_reporting(E_ERROR | E_WARNING | E_PARSE);

//@doc: this class can throw custom exceptions; if need be, wrap your calls with try{} catch(\Exception $e) {}

class AnomaliesHdlr implements AnomaliesHdlr_i
{
    protected $exceptionsMap = [
        "err-a-001"=>"configuration file not found",
        "err-a-002"=>"unvalid configuration file",
        "err-a-003"=>"anomaly level not found",
    ];
    protected $dfltconfigFile = 'config\\anomalies.json';


    protected $exitFallback = 'This page is in maintenance mode.';
    protected $dfltlogconsrvtn = 366;
    protected $minlogconsrvtn = 7;


    protected $configFilePath;
    protected $config;

    public function __construct($autoFetchConfig = true)
    {
        if ($autoFetchConfig === true) {
            $this->setConfigFromFile();
        }
    }

    protected function getDfltConfigPath()
    {
        return dirname(__DIR__).$this->dfltconfigFile;
    }

    public function setConfigFromFile($configFilePath = null)
    {
        if ($configFilePath === null) {
            $configFilePath = $this->getDfltConfigPath();
        }
        if (!file_exists($configFilePath)) {
            throw new \Exception('err-a-001');
            return;
        }
 
        $configContent = json_decode(file_get_contents($configFilePath), true);
        if (empty($configContent) || empty($configContent["anomalies"])) {
            throw new \Exception('err-a-002');
            return;
        }
        $this->config = $configContent["anomalies"];
    }

    public function handle($datatolog, $origin = null, $lvl = 2)
    {
        if (!isset($this->config)) {
            $this->setConfigFromFile();
        }
        if (empty($this->config[$lvl])) {
            if ($lvl != 2 && empty($this->config[2])) {
                throw new \Exception('err-a-003');
                return;
            }
            $lvl = 2;
        }
        $lvldata = $this->config[$lvl];

        if (empty($origin)) {
            $origin = debug_backtrace()[0]['file'];
        }

        $content = ['origin' => $origin, 'data' => [$datatolog]];
        
        $exitContent = false;
        if (!empty($lvldata["exitPage"])) {
            $exitContent = $this->getExitContent($lvldata["exitPage"]);
            if ($exitContent == $this->exitFallback) {
                $content['data'][] = 'AnomaliesHdlr: unvalid path to exit page';
            }
        }

        if (empty($lvldata["logPath"])) {
            $content['data'][] = 'AnomaliesHdlr: log path is not set';
        } else {
            if (empty($lvldata["daysBeforeExpiration"])) {
                $lvldata["daysBeforeExpiration"] = $this->$dfltlogconsrvtn;
            }
            $writelog = $this->updateLog($lvldata["logPath"], $content, $lvldata["daysBeforeExpiration"]);
            if ($writelog === false) {
                $content['data'][] = 'AnomaliesHdlr: an error occured while trying to update log';
                $lvldata["logPath"] = false;
            }
        }
        
        $addt = [];
        if (!empty($lvldata["sendEmail"]["isActive"])) {
            if (empty($lvldata["sendEmail"]["to"]) || empty($lvldata["sendEmail"]["from"])) {
                $missingpart = 'sender';
                if (empty($lvldata["sendEmail"]["to"])) {
                    $missingpart = 'recipient';
                }
                $addt[] = 'AnomaliesHdlr: missing email '.$missingpart.' information';
                $lvldata["sendEmail"]["isActive"] = false;
            } else {
                $sendemail = Utils::sendEmail('Anomaly report', json_encode($content, JSON_PRETTY_PRINT), $lvldata["sendEmail"]["from"], $lvldata["sendEmail"]["to"]);
                if ($sendemail === false) {
                    $addt[] = 'AnomaliesHdlr: fail to send email report';
                    $lvldata["sendEmail"]["isActive"] = false;
                }
            }
        }

        if (!empty($addt) && !empty($lvldata["logPath"])) {
            $this->updateLog($lvldata["logPath"], $addt, $lvldata["daysBeforeExpiration"]);
        }

        if (!empty($exitContent)) {
            $this->outputExitContent($exitContent);
        }
    }

    protected function getExitContent($exitPagePath)
    {
        if (!file_exists($exitPagePath)) {
            return $this->exitFallback;
        } else {
            ob_start();
            include($exitPagePath);
            return ob_get_clean();
        }
    }

    protected function outputExitContent($exitContent)
    {
        exit($exitContent);
    }


    protected function updateLog($logpath, $content, $logconsrvtn)
    {
        if (!is_writable(dirname($logpath))) {
            return false;
        }
        $logconsrvtn = abs(intval($logconsrvtn));
        if ($logconsrvtn < $this->minlogconsrvtn) {
            $logconsrvtn = $this->minlogconsrvtn;
        }
        $timestamp = TimeHdlr::timestamp();
        $log = json_decode(file_get_contents($logpath), true);
        if (empty($log)) {
            $log = [];
        } else {
            //@todo: test
            $timestamps = array_keys($log);
            $c = 0;
            while (TimeHdlr::isOld($timestamps[$c], $timestamp, $logconsrvtn, '%a')) {
                unset($log[$timestamps[$c]]);
                $c++;
            }
        }
        $log[$timestamp] = $content;
        return file_put_contents($logpath, json_encode($log, JSON_PRETTY_PRINT), LOCK_EX);
    }
}
