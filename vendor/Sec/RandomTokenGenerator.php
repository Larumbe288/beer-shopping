<?php
/**
 * Created by PhpStorm.
 * User: amarciales
 * Date: 25/10/2018
 * Time: 8:47
 */

namespace Ngcs\Core\Sec;

/**
 * Class RandomTokenGenerator
 * @package Ngcs\Core\Sec
 */
class RandomTokenGenerator
{
    /**
     * @param int $length
     * @return string
     * @throws \Exception
     */
    public function generate($length = 16)
    {
        $length = ($length < 16) ? 16 : $length;
        if (function_exists('random_bytes'))
        {
            return bin2hex(random_bytes($length));
        }
        return bin2hex(openssl_random_pseudo_bytes($length));
    }
}