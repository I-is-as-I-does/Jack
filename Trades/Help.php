<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */
namespace SSITU\Jack;


class Help implements \SSITU\Jack\Interfaces\Help_i {

    public static function isValidHexColor(string $hexCode)
    {
        return !empty(preg_match("/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/", $hexCode));
    }

    public static function resolveHexColor(string $hexCode)
    {
        if (!empty($hexCode) && is_string($hexCode)) {
            if ($hexCode[0] != '#') {
                $hexCode = '#' . $hexCode;
            }
            if (self::isValidHexColor($hexCode)) {
                return $hexCode;
            }
        }
        return false;
    }

    public static function filterBool(mixed $var)
    {
        $san = filter_var($var, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        if ($san === null) {
            return false;
        }
        return true;
    }

    public static function filterValue(mixed $var, $filter = FILTER_SANITIZE_STRING)
    {
        $san = filter_var($var, $filter);
        if ($san == $var) {
            return true;
        }
        return false;
    }

    public static function intLen(int $int)
    {
        return $int !== 0 ? floor(log10($int) + 1) : 1;
    }

    public static function UpCamelCase(string $string)
    {
        $splt = preg_split('/[^A-Za-z0-9]+|(?=[A-Z])/', $string);
        $splt = array_map('ucfirst', $splt);
        return implode('', $splt);
    }

    public static function isHTML(string $string)
    {
        if ($string != strip_tags($string)) {
            return true;
        }
        return false;
    }

    public static function isPostvInt(mixed $value)
    { //  @doc works even if $value is a string-integer
        return ((is_int($value) || ctype_digit($value)) && (int) $value > 0);
    }

    public static function isValidPattern(string $pattern)
    {
        $pattern = '/' . trim($pattern, '/') . '/';
        if (@preg_match($pattern, null) === false) {
            return false;
        }
        return true;
    }

    public static function boolify(mixed $value)
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    public static function num2alpha(int $n)
    {
        $r = '';
        for ($i = 1; $n >= 0 && $i < 10; $i++) {
            $r = chr(0x41 + ($n % pow(26, $i) / pow(26, $i - 1))) . $r;
            $n -= pow(26, $i);
        }
        return $r;
    }
    public static function alpha2num(string $a)
    {
        $r = 0;
        $l = strlen($a);
        for ($i = 0; $i < $l; $i++) {
            $r += pow(26, $i) * (ord($a[$l - $i - 1]) - 0x40);
        }
        return $r - 1;
    }

    public static function intIsInRange(int | string $int, int | string $min, int | string $max)
    {
        return filter_var(
            (int) $int,
            FILTER_VALIDATE_INT,
            array(
                'options' => array(
                    'min_range' => (int) $min,
                    'max_range' => (int) $max,
                ),
            )
        );
    }

}
