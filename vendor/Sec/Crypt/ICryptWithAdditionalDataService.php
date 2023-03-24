<?php

namespace Ngcs\Core\Sec\Crypt;

use InvalidArgumentException;

/**
 * Interface ICryptWithAdditionalDataService
 * @package Ngcs\Core\Sec\Crypt
 */
interface ICryptWithAdditionalDataService
{
    /**
     * @param string $message
     * @param string $additionalData
     * @return string
     * @throws InvalidArgumentException
     */
    public function encryptWithAdditionalData(string $message, string $additionalData): string;

    /**
     * @param string $message64
     * @param string $additionalData
     * @return string
     * @throws InvalidArgumentException
     */
    public function decryptWithAdditionalData(string $message64, string $additionalData): string;
}
