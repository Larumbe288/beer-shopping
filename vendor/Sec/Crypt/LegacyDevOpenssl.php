<?php

namespace Ngcs\Core\Sec\Crypt;

/**
 * Class LegacyDevOpenssl
 * @package Ngcs\Core\Sec\Crypt
 */
class LegacyDevOpenssl extends Openssl
{
    private bool $isDevEnv;

    /**
     * LegacyDevOpenssl constructor.
     * @param bool $isDev
     * @param string $method
     * @param string $key
     * @param string|null $hashKey
     */
    public function __construct(bool $isDev, string $method, string $key, string $hashKey = null)
    {
        $this->isDevEnv = $isDev;
        parent::__construct($method, $key, $hashKey);
    }

    /**
     * @return bool
     */
    public function isDevelopment(): bool
    {
        return $this->isDevEnv;
    }

    /**
     * @param string $message64
     * @return string
     */
    public function decryptWithHmac(string $message64): string
    {
        if ($this->isDevelopment()) {
            if (preg_match('/(.*)\-ENCODED/s', $message64, $matches)) {
                return html_entity_decode($matches[1]);
            }
        }
        return parent::decryptWithHmac($message64);
    }

    /**
     * @param string $message
     * @return string
     */
    public function encryptWithHmac(string $message): string
    {
        if ($this->isDevelopment()) {
            return $message . '-ENCODED';
        }
        return parent::encryptWithHmac($message);
    }
}