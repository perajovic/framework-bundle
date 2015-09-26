<?php

namespace SupportYard\FrameworkBundle\Utils;

class PasswordHelper
{
    /**
     * @param string $password
     *
     * @return string
     */
    public static function hash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * @param string $password
     * @param string $hash
     *
     * @return bool
     */
    public static function verify($password, $hash)
    {
        return password_verify($password, $hash);
    }

    /**
     * @param int $length
     *
     * @return string
     */
    public static function generate($length = 15)
    {
        $password = '';

        $chars = str_shuffle(
            time().'0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'
        );
        $charsLength = strlen($chars);

        for ($i = 0; $i < $length; ++$i) {
            $password .= substr($chars, rand(0, $charsLength - 1), 1);
        }

        return $password;
    }
}
