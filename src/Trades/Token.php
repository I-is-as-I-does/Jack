<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */
namespace SSITU\Jack\Trades;

use \SSITU\Jack\Jack;

class Token implements Token_i
{


    public function timeBased()
    {
        return md5(uniqid(microtime(), true));
    }

    public function sha40char()
    {
        return sha1(rand());
    }

    public function getSecrets($token, $eligiblechars)
    {
        if (!is_array($eligiblechars)) {
            $eligiblechars = str_split($eligiblechars);
        }
        $search = array_intersect($eligiblechars, str_split($token));
        if (empty($search)) {
            return false;
        }
        return $search;
    }

    public function withSecret($secretchar, $pool, $tokenlength)
    {
        if (!is_array($pool)) {
            $pool = str_split($pool);
        }
        $base = array_rand(array_flip($pool), $tokenlength);
        $poz = rand(0, $tokenlength - 1);
        $base[$poz] = $secretchar;
        return implode('', $base);
    }

    public function b64basic($bytes = 64)
    {
        return base64_encode(random_bytes($bytes));
    }

    
    public function hexBytes($bytes = 32)
    {
        return bin2hex(random_bytes($bytes));
    }

    public function passType($length = 32){
        if($length < 8){
            $length = 8;
        }
        $methods = ['randLetter',
        'randomDigit',
        'randomSpeChar',
        'randLetter'];
        $tok = '';
        foreach($methods as $method){
            $tok .= Jack::Help()->$method();
            $length--;
        }
        while($length > 0){
            $randMethod = $methods[random_int(0, 3)];
            $tok .= Jack::Help()->$randMethod();
            $length--;
        }
        
        return str_shuffle($tok);
    }
}
