<?php
/**
 * Created by PhpStorm.
 * User: amarciales
 * Date: 25/10/2018
 * Time: 12:30
 */

namespace Ngcs\Core\Sec\Crypt;

/**
 * Class Sha512PasswordHash
 * @package Ngcs\Core\Sec\Crypt
 */
class Sha512PasswordHash
{
    /**
     * @param string $password
     * @param string $salt
     * @return string
     */
    public function hash(string $password, string $salt = ''): string
    {
        $hash = $password . $salt;

        // SHA-512 with multiple rounds
        $rounds = 12;
        for ($i = 0; $i < $rounds; $i++)
        {
            $hash = hash('sha512', $hash);
        }

        return $hash;
    }
}