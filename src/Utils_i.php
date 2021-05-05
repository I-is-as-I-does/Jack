<?php 
/* This file is part of Jacks | ExoProject | (c) 2021 I-is-as-I-does | MIT License */
namespace ExoProject\Jacks;

interface Utils_i
{
    public static function sendEmail($subject, $content, $sender, $recipient, $sitename);
    public static function isAlive($theURL);
    public static function isPostvInt($value);
    public static function boolify($val);
}