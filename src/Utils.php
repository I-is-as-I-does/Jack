<?php
/* This file is part of Jacks | ExoProject | (c) 2021 I-is-as-I-does | MIT License */
namespace ExoProject\Jacks;

class Utils implements Utils_i
{
    public static function sendEmail($subject, $content, $sender, $recipient)
    {
        /* @doc: using a custom function can avoid some injections, else website/app can turn into a spam distributor.
           Plus it's convenient to mutualise headers and encoding. */

        $sitename = $_SERVER['HTTP_HOST'];
        $headers = [
          'From' => $sender,
          'Reply-To' => $recipient,
          'X-Mailer' => 'PHP/' . phpversion(),
          'Content-Type' => 'text/plain; charset=utf-8',
          'Content-Transfer-Encoding' => 'base64'
        ];
      
        $to = '=?UTF-8?B?' . base64_encode($sitename) . '?= <' . $recipient . '>';
        $subj = '=?UTF-8?B?' . base64_encode($subject) . '?=';
        $msg = base64_encode($content);
      
        if (mail($to, $subj, $msg, $headers)) {
            return true;
        }
        return false;
    }

    public static function isAlive($theURL)
    {
        if (filter_var($theURL, FILTER_VALIDATE_URL)) {
            $headers = @get_headers($theURL);
            $resp_code = substr($headers[0], 9, 3);
            if (intval($resp_code) > 0 && intval($resp_code) < 400) {
                return true;
            }
        }
        return false;
    }

    public static function isPostvInt($value)
    { //  @doc works even if value is a string-integer
        return ((is_int($value) || ctype_digit($value)) && (int)$value > 0);
    }

    public static function boolify($val)
    {
        return filter_var($val, FILTER_VALIDATE_BOOLEAN);
    }
}
