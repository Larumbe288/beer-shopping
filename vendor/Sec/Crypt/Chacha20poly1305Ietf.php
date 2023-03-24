<?php
/**
 * Created by PhpStorm.
 * User: amarciales
 * Date: 26/10/2018
 * Time: 10:55
 */

namespace Ngcs\Core\Sec\Crypt;

use Exception;
use InvalidArgumentException;
use SodiumException;

/**
 * Class Chacha20poly1305Ietf
 * @package Ngcs\Core\Sec\Crypt
 */
class Chacha20poly1305Ietf implements ICryptService, ICryptWithAdditionalDataService
{
    private string $key;

    /**
     * Chacha20poly1305Ietf constructor.
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $message
     * @return string
     * @throws InvalidArgumentException
     * @throws Exception
     */
    public function encrypt(string $message): string
    {

        $nonce = random_bytes(SODIUM_CRYPTO_AEAD_CHACHA20POLY1305_IETF_NPUBBYTES); // NONCE = Number to be used ONCE, for each message
        $encrypted = sodium_crypto_aead_chacha20poly1305_ietf_encrypt(
            $message,
            $nonce,
            $nonce,
            $this->getKey()
        );

        return base64_encode($nonce . $encrypted);
    }


    /**
     * @param string $message64
     * @return string
     * @throws InvalidArgumentException
     * @throws SodiumException
     */
    public function decrypt(string $message64): string
    {
        $message = base64_decode($message64);
        $nonce = mb_substr($message, 0, SODIUM_CRYPTO_AEAD_CHACHA20POLY1305_IETF_NPUBBYTES, '8bit');
        $ciphertext = mb_substr($message, SODIUM_CRYPTO_AEAD_CHACHA20POLY1305_IETF_NPUBBYTES, null, '8bit');
        $plaintext = sodium_crypto_aead_chacha20poly1305_ietf_decrypt(
            $ciphertext,
            $nonce,
            $nonce,
            $this->getKey()
        );
        if (!is_string($plaintext)) {
            throw new InvalidArgumentException('Invalid message');
        }
        return $plaintext;
    }

    /**
     * @param string $message
     * @param string $additionalData
     * @return string
     * @throws SodiumException
     * @throws Exception
     */
    public function encryptWithAdditionalData(string $message, string $additionalData): string
    {
        $nonce = random_bytes(SODIUM_CRYPTO_AEAD_CHACHA20POLY1305_IETF_NPUBBYTES); // NONCE = Number to be used ONCE, for each message
        $encrypted = sodium_crypto_aead_chacha20poly1305_ietf_encrypt(
            $message,
            $additionalData,
            $nonce,
            $this->getKey()
        );

        return base64_encode($nonce . $encrypted);
    }

    /**
     * @param string $message64
     * @param string $additionalData
     * @return string
     * @throws SodiumException
     * @throws InvalidArgumentException
     */
    public function decryptWithAdditionalData(string $message64, string $additionalData): string
    {
        $message = base64_decode($message64);
        $nonce = mb_substr($message, 0, SODIUM_CRYPTO_AEAD_CHACHA20POLY1305_IETF_NPUBBYTES, '8bit');
        $ciphertext = mb_substr($message, SODIUM_CRYPTO_AEAD_CHACHA20POLY1305_IETF_NPUBBYTES, null, '8bit');
        $plaintext = sodium_crypto_aead_chacha20poly1305_ietf_decrypt(
            $ciphertext,
            $additionalData,
            $nonce,
            $this->getKey()
        );

        if (!is_string($plaintext)) {
            throw new InvalidArgumentException('Invalid message');
        }

        return $plaintext;
    }
}
