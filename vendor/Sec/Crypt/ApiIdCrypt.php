<?php
/**
 * Created by PhpStorm.
 * User: amarciales
 * Date: 25/10/2018
 * Time: 17:30
 */

namespace Ngcs\Core\Sec\Crypt;

/**
 * Used on old APIs
 * Class ApiIdCrypt
 * @package Ngcs\Core\Sec\Crypt
 */
class ApiIdCrypt
{
    private $encryptionKey;

    /**
     * ApiIdCrypt constructor.
     * @param string $encryptionKey
     */
    public function __construct(string $encryptionKey)
    {
        $this->encryptionKey = $encryptionKey;
    }

    /**
     * @return string
     */
    public function getEncryptionKey(): string
    {
        return $this->encryptionKey;
    }

    /**
     * @param int $id
     * @return string
     */
    public function encryptId(int $id): string
    {
        $val = "$id";
        $key = $this->getEncryptionKey();

        $len = (strlen($key) < 16 ? 16 : (strlen($key) < 24 ? 24 : 32));
        $secret = substr($key . str_repeat("\0", 32), 0, $len);
        $method = ($len == 16 ? 'aes-128-ecb' : ($len == 24 ? 'aes-192-ecb' : 'aes-256-ecb'));
        $block = 16;
        $pad = $block - (strlen($val) % $block);
        $val .= str_repeat(chr(0), $pad);
        $string = openssl_encrypt($val, $method, $secret, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING);

        $hex = '';
        for ($i = 0; $i < strlen($string); $i++)
        {
            $ord = ord($string[$i]);
            $hexCode = dechex($ord);
            $hex .= substr('0' . $hexCode, -2);
        }
        return strtoupper($hex);

    }

    /**
     * @param string $id
     * @return int
     */
    public function decryptId(string $id): int
    {
        $string = '';
        for ($i = 0; $i < strlen($id) - 1; $i += 2)
        {
            $string .= chr(hexdec($id[$i] . $id[$i + 1]));
        }
        $key = $this->getEncryptionKey();
        $len = (strlen($key) < 16 ? 16 : (strlen($key) < 24 ? 24 : 32));
        $secret = substr($key . str_repeat("\0", 32), 0, $len);
        $method = ($len == 16 ? 'aes-128-ecb' : ($len == 24 ? 'aes-192-ecb' : 'aes-256-ecb'));

        return (int)trim(openssl_decrypt($string, $method, $secret, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING));
    }

}