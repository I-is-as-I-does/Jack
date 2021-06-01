<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */
namespace SSITU\Jack;

class Jack implements Jack_i
{
    private static $token;
    private static $file;
    private static $help;
    private static $time;
    private static $admin;

    public static function Admin()
    {
        if (empty(self::$admin)) {
            self::$admin = new Trades\Admin();
        }
        return self::$admin;
    }
    public static function Token()
    {
        if (empty(self::$token)) {
            self::$token = new Trades\Token();
        }
        return self::$token;
    }
    public static function File()
    {
        if (empty(self::$file)) {
            self::$file = new Trades\File();
        }
        return self::$file;
    }
    public static function Help()
    {
        if (empty(self::$help)) {
            self::$help = new Trades\Help();
        }
        return self::$help;
    }
    public static function Time()
    {
        if (empty(self::$time)) {
            self::$time = new Trades\Time();
        }
        return self::$time;
    }
}
