<?php
/**
 * Created by PhpStorm.
 * User: amarciales
 * Date: 25/10/2018
 * Time: 8:59
 */

namespace Ngcs\Core\Sec;

/**
 * Class UuidV4Generator
 * @package Ngcs\Core\Sec
 */
class UuidV4Generator
{
    /**
     * @return string
     * @throws \Exception
     */
    public function generate()
    {
        return UuidV4Generator::generateUuid();

    }


    /**
     * @return string
     * @throws \Exception
     */
    public static function generateUuid(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));

    }
}