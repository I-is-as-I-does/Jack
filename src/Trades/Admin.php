<?php
/* This file is part of Jack | SSITU | (c) 2021 I-is-as-I-does | MIT License */

namespace SSITU\Jack\Trades;

class Admin implements Admin_i
{

    public function bestHashCost($timeTarget = 0.05, $cost = 8, $algo = PASSWORD_DEFAULT)
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

    public function serverInfos()
    {
        phpinfo(32);
    }

    public function phpInfo()
    {
        phpinfo();
    }

    public function generateCryptKey($bytes = 32)
    {
        return bin2hex(random_bytes($bytes));
    }

    public function hashAdminKey($adminKey){
        return password_hash($adminKey, PASSWORD_BCRYPT);
    }

   
}
