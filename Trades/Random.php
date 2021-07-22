<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */
namespace SSITU\Jack;


class Random implements \SSITU\Jack\Interfaces\Random_i {

    public static function boolean()
    {
        return (bool) random_int(0, 1);
    }

    public static function digit()
    {
        return random_int(0, 9);
    }

    public static function speChar(string | array $speChars = '*&!@%^#$')
    {

        return $speChars[random_int(0, 7)];
    }

    public static function multLetters(int $count, string $case = 'random')
    {
        $out = '';
        for ($c = 0; $c < $count; $c++) {
            $out .= self::letter($case);
        }
        return $out;
    }

    public static function letter(string $case = 'random')
    {
        $a_z = "abcdefghijklmnopqrstuvwxyz";
        $rand_letter = $a_z[random_int(0, 25)];
        if ($case == 'random') {
            $case = self::boolean();
        }
        if ($case == true || $case == 'upper') {
            return strtoupper($rand_letter);
        }
        return $rand_letter;
    }

    public static function mix(int $bytes = 32, string | array $speChars = '*&!@%^#$')
    {
        if ($bytes < 8) {
            $bytes = 8;
        }

        $methods = ['letter' => 'random',
            'digit' => null];
        if (!empty($speChars)) {
            $methods['speChar'] = $speChars;
        }
        $tok = '';
        foreach ($methods as $method => $arg) {
            $tok .= self::$method(...[$arg]);
        }

        while (strlen($tok) != $bytes) {
            $randMethod = array_rand($methods);
            $arg = $methods[$randMethod];
            $tok .= self::$randMethod(...[$arg]);
        }

        return str_shuffle($tok);
    }

}
