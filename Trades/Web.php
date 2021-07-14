<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */
namespace SSITU\Jack;

class Web
{

    public static function redirect($url)
    {
        header('Location: ' . $url);
        exit;
    }

    public static function addQueries($pageUrl, $queries)
    {
        if(substr($pageUrl,-1) !== '?'){
            $pageUrl .= '?';
        }
        foreach ($queries as $key => $val) {
            $pageUrl .= '&' . $key . '=' . $val;
        }
        return $pageUrl;
    }

    public static function getProtocol()
    {
        $protoc = 'http';
        if ((!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') ||
            $_SERVER['SERVER_PORT'] == 443
        ) {
            $protoc .= 's';
        }
        return $protoc;
    }

    public static function isAlive($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            $headers = @get_headers($url);
            $resp_code = substr($headers[0], 9, 3);
            if (intval($resp_code) > 0 && intval($resp_code) < 400) {
                return true;
            }
        }
        return false;
    }

    public static function httpPost($url, $data)
    {
        // @doc: $data is an associative array of fields, like:
        // $data = ["a" => "xyz", "b" => "123"];
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response; //it's always useful to at least return "true" on the other end
    }

    public static function b64url_encode($data)
    { //@doc: $data must be already encoded in b64
        return str_replace(['+', '/', '='], ['-', '_', ''], $data);
    }

    public static function b64url_decode($data)
    { //@doc: returns b64 ; requires php 7
        return str_replace(['-', '_'], ['+', '/'], $data);
    }

    public static function extractSubDomain($url = null, $exlude_www = true)
    {
        //@doc: this method WILL exclude www
        if(empty($url)){
            $url = $_SERVER['SERVER_NAME'];
        }
        $trimPattern = '^(https?)?([:\/])*';
        if($exlude_www){
            $trimPattern .= '(www\.)?';
        }
        $url = preg_replace('/'.$trimPattern.'/','',$url);
        preg_match('/^([\w-]+)(?=\.[\w-]+\.)/', $url, $matches);
        if (!empty($matches)) {
            return $matches[0];
        }
        return false;
    }
}
