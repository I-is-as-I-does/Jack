<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */

namespace SSITU\Jack\Trades;

class Web implements Web_i
{

    public function redirect($url)
    {
        header('Location: ' . $url);
        exit;
    }

    public function getProtocol()
    {
        $protoc = 'http';
        if ((!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') ||
            $_SERVER['SERVER_PORT'] == 443
        ) {
            $protoc .= 's';
        }
        return $protoc;
    }

    public function isAlive($url)
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

    public function getSubDomain($noWWW = true)
    {
        $splithost = explode('.', $_SERVER['HTTP_HOST']);
        $subdomain = $splithost[0];
        if ($noWWW && $subdomain === 'www') {
            $subdomain = $splithost[1];
        }
        return $subdomain;
    }

    public function httpPost($url, $data)
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

    public function b64url_encode($data)
    { //@doc: $data must be already encoded in b64
        return str_replace(['+', '/', '='], ['-', '_', ''], $data);
    }

    public function b64url_decode($data)
    { //@doc: returns b64 ; requires php 7
        return str_replace(['-', '_'], ['+', '/'], $data);
    }
}
