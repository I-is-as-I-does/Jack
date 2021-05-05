<?php
/* This file is part of Jacks | ExoProject | (c) 2021 I-is-as-I-does | MIT License */
namespace ExoProject\Jacks;

class TokenHdlr implements TokenHdlr_i
{
    public static function timeBasedToken()
    {
        return md5(uniqid(microtime(), true));
    }

    public static function getSecretsFromToken($token, $eligiblechars)
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
    
    public static function tokenWithSecret($secretchar, $pool, $tokenlength)
    {
        if (!is_array($pool)) {
            $pool = str_split($pool);
        }
        $base = array_rand(array_flip($pool), $tokenlength);
        $poz = rand(0, $tokenlength-1);
        $base[$poz] = $secretchar;
        return implode('', $base);
    }

    public static function nonce($bytesnbr = 64)
    {
        return base64_encode(random_bytes($bytesnbr));
    }
}
