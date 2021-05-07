<?php
use ExoProject\Jacks\Time;

require_once(dirname(__DIR__).'\\composer\\autoload.php');

var_dump(Time::isValidTimezone('Europe/Paris'));
