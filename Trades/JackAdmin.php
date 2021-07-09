<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */
namespace SSITU\Jack;

class JackAdmin
{

    public static function bestHashCost($timeTarget = 0.05, $cost = 8, $algo = PASSWORD_DEFAULT)
    {
/** @source: www.php.net/manual
 * This code will benchmark your server to determine how high of a cost you can
 * afford. You want to set the highest cost that you can without slowing down
 * you server too much. 8-10 is a good baseline, and more is good if your servers
 * are fast enough. By default, the code aims for ≤ 50 milliseconds stretching time,
 * which is a good baseline for systems handling interactive logins.
 */
        do {
            $cost++;
            $start = microtime(true);
            password_hash("test", $algo, ["cost" => $cost]);
            $end = microtime(true);
        } while (($end - $start) < $timeTarget);

        return "Appropriate Cost Found: " . $cost;
    }

    public static function serverInfos()
    {
        phpinfo(32);
    }

    public static function phpInfo()
    {
        phpinfo();
    }

    public static function hashAdminKey($adminKey)
    {
        return password_hash($adminKey, PASSWORD_BCRYPT);
    }

}
