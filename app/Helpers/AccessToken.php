<?php

namespace App\Helpers;

class AccessToken {

    /**
     *
     *
     * @param  string  $date1 YY-MM-DD HH:MM:SS
     * @param  string  $date2 YY-MM-DD HH:MM:SS
     * @return object  time diff
     */
    public static function generateAccessToken() {
        return AccessToken::ramdomToken(64);
    }

    public static function ramdomToken($bit) {
        $characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $i = 0;
        $salt = "";
        while ($i < $bit) {
            $salt .= $characterList{mt_rand(0, (strlen($characterList) - 1))};
            $i++;
        }
        
        return $salt;
    }

}
