<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */
namespace SSITU\Jack;

class Jack
{
    private static $_this;
    private $classMap = [];

    public function __construct()
    {
        self::$_this = $this;
        $trades = glob(__DIR__ . '/Trades/*[!(_i)].php');
        foreach ($trades as $trade) {
            $this->classMap[basename($trade, '.php')] = null;
        }
    }

    public static function __callStatic($name, $arg)
    {
        return self::inst()->call($name);
    }

    private function call($name)
    {
        if (!array_key_exists($name, $this->classMap)) {
            return false;
        }
        if (empty($this->classMap[$name])) {
            $subClassName = __NAMESPACE__ . '\\Trades\\' . $name;
            $this->classMap[$name] = new $subClassName();
        }
        return $this->classMap[$name];
    }

    private static function inst()
    {
        if (empty(self::$this)) {
            return new Jack();
        }
        return self::$this;
    }
}
