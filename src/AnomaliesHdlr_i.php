<?php 
/* This file is part of Jacks | ExoProject | (c) 2021 I-is-as-I-does | MIT License */
namespace ExoProject\Jacks;

interface AnomaliesHdlr_i
{
    public static function updateLog($logpath, $contnt, $loglength);
    public static function record($datatolog, $currFile, $logfile, $exit);
    public static function exitPage($e);
}