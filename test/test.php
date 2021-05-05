<?php
use ExoProject\Jacks\TimeHdlr;

require_once('./vendor/autoload.php');

var_dump(TimeHdlr::isValidTimezone('Europe/Paris'));

var_dump($_SERVER['HTTP_HOST']);