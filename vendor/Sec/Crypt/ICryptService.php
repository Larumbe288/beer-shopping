<?php
/**
 * Created by PhpStorm.
 * User: amarciales
 * Date: 30/10/2018
 * Time: 8:58
 */

namespace Ngcs\Core\Sec\Crypt;

/**
 * Interface ICryptService
 * @package Ngcs\Core\Sec\Crypt
 */
interface ICryptService
{
    /**
     * @param string $message
     * @return string
     * @throws \InvalidArgumentException
     */
    public function encrypt(string $message): string;

    /**
     * @param string $message64
     * @return string
     * @throws \InvalidArgumentException
     */
    public function decrypt(string $message64): string;
}