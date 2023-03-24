<?php
/**
 * Created by PhpStorm.
 * User: amarciales
 * Date: 25/10/2018
 * Time: 10:09
 */

namespace Ngcs\Core\Sec\Crypt;

use InvalidArgumentException;

/**
 * Class Openssl
 * @package Ngcs\Core\Sec\Crypt
 */
class Openssl implements ICryptService
{
    public const METHOD_AES_256_CTR = 'aes-256-ctr';

    private $method;
    private $key;
    private $hashKey;
    private $ivsize;

    /**
     * Openssl constructor.
     * @param string $method
     * @param string $key
     * @param string|null $hashKey
     * @throws InvalidArgumentException
     */
    public function __construct(string $method, string $key, string $hashKey = null)
    {
        if (!in_array($method, openssl_get_cipher_methods())) {
            throw new InvalidArgumentException("Cryptor:: - unknown cipher algo {$method}");
        }

        $this->ivsize = openssl_cipher_iv_length($method);
        if ((mb_strlen($key, '8bit') < $this->ivsize) || (mb_strlen($key, '8bit') < 24)) {
            throw new InvalidArgumentException("Needs a " . ($this->ivsize * 8) . "-bit key!");
        }
        $this->method = $method;
        $this->key = $key;
        $this->hashKey = $hashKey ?: $key;

    }

    /**
     * @param string $message
     * @return string
     * @throws InvalidArgumentException
     */
    public function encrypt(string $message): string
    {
        $iv = openssl_random_pseudo_bytes($this->ivsize);


        $ciphertext = openssl_encrypt(
            $message,
            $this->method,
            $this->key,
            OPENSSL_RAW_DATA,
            $iv
        );

        if ($ciphertext === false) {
            throw new InvalidArgumentException("Cannot encrypt");
        }
        return base64_encode($iv . $ciphertext);
    }

    /**
     * @param string $message64
     * @return string
     * @throws InvalidArgumentException
     */
    public function decrypt(string $message64): string
    {
        $message = base64_decode($message64);

        if (strlen($message) < ($this->ivsize)) {
            throw new InvalidArgumentException("Invalid lenght");
        }

        $iv = mb_substr($message, 0, $this->ivsize, '8bit');
        $ciphertext = mb_substr($message, $this->ivsize, null, '8bit');

        $unCipherText = openssl_decrypt(
            $ciphertext,
            $this->method,
            $this->key,
            OPENSSL_RAW_DATA,
            $iv
        );

        if ($unCipherText === false) {
            throw new InvalidArgumentException("Cannot decrypt");
        }

        return $unCipherText;

    }

    /**
     * @param string $message
     * @return string
     */
    public function encryptWithHmac(string $message): string
    {

        $iv = openssl_random_pseudo_bytes($this->ivsize);

        $keyhash = openssl_digest($this->key, 'sha256', true);

        $ciphertext = openssl_encrypt(
            $message,
            $this->method,
            $keyhash,
            OPENSSL_RAW_DATA,
            $iv
        );
        if ($ciphertext === false) {
            throw new InvalidArgumentException("Cannot decrypt");
        }
        $hmac = hash_hmac('sha256', $iv . $ciphertext, $this->hashKey, true);

        return base64_encode($iv . $hmac . $ciphertext);
    }

    /**
     * @param string $message64
     * @return string
     * @throws InvalidArgumentException
     */
    public function decryptWithHmac(string $message64): string
    {
        $message = base64_decode($message64);


        $iv = mb_substr($message, 0, $this->ivsize, '8bit');
        $hmac = mb_substr($message, $this->ivsize, 32, '8bit');
        $ciphertext = mb_substr($message, $this->ivsize + 32, null, '8bit');

        $calculated = hash_hmac('sha256', $iv . $ciphertext, $this->hashKey, true);

        if (!hash_equals($hmac, $calculated)) {
            throw new InvalidArgumentException("Invalid message");
        }
        $keyhash = openssl_digest($this->key, 'sha256', true);

        $unCipherText = openssl_decrypt(
            $ciphertext,
            $this->method,
            $keyhash,
            OPENSSL_RAW_DATA,
            $iv
        );

        if ($unCipherText === false) {
            throw new InvalidArgumentException("Cannot decrypt");
        }

        return $unCipherText;

    }

}