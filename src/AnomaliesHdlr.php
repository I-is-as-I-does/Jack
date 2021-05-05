<?php
/* This file is part of Jacks | ExoProject | (c) 2021 I-is-as-I-does | MIT License */
namespace ExoProject\Jacks;

// @doc: in a dev env., you can also use:
// error_reporting(E_ERROR | E_WARNING | E_PARSE);

class AnomaliesHdlr implements AnomaliesHdlr_i
{
    public $exceptionsMap = [
        "err-a-001"=>"configuration file not found",
        "err-a-002"=>"unvalid configuration file",
        "err-a-002"=>"anomaly level not found",
    ];
    public $lastFallback = 'This page is in maintenance mode.';
    public $dfltconfigFile = 'config\\anomalies.json';
    public $dfltloglength = 500;
    protected $configFilePath;
    protected $config;

    public function __construct($autoSetConfig = true)
    {
        if ($autoSetConfig === true) {
            $this->setConfig();
        }
    }

    public function setConfigPath($configFilePath = null)
    {
        if ($configFilePath === null) {
            $configFilePath = dirname(__DIR__).$this->dfltconfigFile;
        }
        if (!file_exists($configFilePath)) {
            return false;
        }
        $this->configFilePath = $configFilePath;
        return true;
    }

    public function getConfigPath()
    {
        if (!empty($this->configFilePath)) {
            return $this->configFilePath;
        }
        return false;
    }

    public function setConfig($configContent = null)
    {
        if ($configContent === null) {
            if (!isset($this->configFilePath)) {
                $setpath = $this->setConfigPath();
                if (!$setpath) {
                    throw new \Exception('err-a-001');
                    exit;
                }
            }
            $configContent = file_get_contents($this->configFilePath);
        }
        if (!is_array($configContent)) {
            $configContent = json_decode($configContent, true);
        }
        if (empty($configContent) || empty($configContent["anomalies"])) {
            throw new \Exception('err-a-002');
            exit;
        }
        $this->config = $configContent["anomalies"];
    }
 
    public function getConfig()
    {
        if (!empty($this->config)) {
            return $this->config;
        }
        return false;
    }

    public function handle($datatolog, $origin = null, $lvl = 2)
    {
        if (!isset($this->config)) {
            $this->setConfig();
        }
        if (empty($this->config[$lvl])) {
            if ($lvl != 2 && empty($this->config[2])) {
                throw new \Exception('err-a-003');
                exit;
            }
            $lvl = 2;
        }
        $lvldata = $this->config[$lvl];

        if (empty($origin)) {
            $origin = debug_backtrace()[0]['file'];
        }

        $content = ['origin' => $origin, 'data' => $datatolog];


        if (!empty($lvldata["logPath"])) {
            if (empty($lvldata["maxLogEntries"])) {
                $lvldata["maxLogEntries"] = $this->$dfltloglength;
            }
            $writelog = $this->updateLog($lvldata["logPath"], $content, $lvldata["maxLogEntries"]);
            if ($writelog === false) {
                $content['addt'] = ['AnomaliesHdlr: an error occured while trying to update log'];
            }
        } else {
            $content['addt'] = ['AnomaliesHdlr: log path is not set'];
        }

        if (!empty($lvldata["sendEmail"]) && !empty($lvldata["sendEmail"]["to"]) && !empty($lvldata["sendEmail"]["from"])) {
            $sendemail = Utils::sendEmail('Anomaly report', json_encode($content,JSON_PRETTY_PRINT), $lvldata["sendEmail"]["from"],$lvldata["sendEmail"]["to"], );
        }

        if (!empty($lvldata["exitPage"]) && !file_exists($lvldata["exitPage"])) {
            if (!isset($content['addt'])) {
                $content['addt'] = [];
            }
            $content['addt'][] = 'AnomaliesHdlr: unvalid path to exit page';
        }
    
        if (!empty($lvldata["exitPage"])) {
            $output = $this->outputExitPage($lvldata["exitPage"]);
            if (!$output) {
            }
        }
    }

    public static function updateLog($logpath, $content, $loglength = null)
    {
        if (empty($loglength) || !Utils::isPostvInt($loglength)) {
            $loglength = $this->$dfltloglength;
        }
        if (!is_writable(dirname($logpath))) {
            return false;
        }

        $timestamp = TimeHdlr::timestamp();
        $log = json_decode(file_get_contents($logpath), true);
        if (empty($log)) {
            $log = [];
        } elseif (count($log) > $loglength) {
        }
        $log[$timestamp] = $content;
        return file_put_contents($logpath, json_encode($log, JSON_PRETTY_PRINT), LOCK_EX);
    }

    public static function outputExitPage($exitPagePath, $fallback = null)
    {
        if (file_exists($exitPagePath)) {
            require($exitPagePath);
            exit;
        }
        if (!empty($fallback)) {
            exit($fallback);
        }
        exit($this->lastFallback);
    }
}
