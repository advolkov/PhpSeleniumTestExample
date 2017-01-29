<?php

class DataGenerator
{
    const DEFAULT_USER_EMAIL_DOMAIN = "test.com";

    public static function generateRandomString($length = 10, $charset = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789")
    {
        $count = strlen($charset);
        if ($charset === null) {
            $charset = array_map("chr", range(1, 255));
            $count = count($charset);
        }
        $str = "";
        while ($length--) {
            $str .= $charset[rand(0, $count - 1)];
        }

        return $str;
    }

    public static function generateRandomUserName($length = 5)
    {
        return self::generateRandomString($length);
    }

    public static function generateRandomUserEmail($length = 5)
    {
        return self::generateRandomString($length) . "@" . self::DEFAULT_USER_EMAIL_DOMAIN;
    }

    public static function generateRandomPassword($length = 10)
    {
        //password needs at least one number
        return rand() . self::generateRandomString($length);
    }

    public static function generateBadUserNamesArray()
    {
        return [
            [self::generateRandomString(5, "-_)(,./[]{}^%&^!@#")], //only some special symbols
            [" "],
            [""],
        ];
    }

    public static function generateBadEmailsArray()
    {
        return [
            [self::generateRandomString()],
            [rand()],
            [self::generateRandomString(5) . "@" . str_replace(".", "", self::DEFAULT_USER_EMAIL_DOMAIN)],
            [" "],
            [""],
        ];
    }
}
