<?php
declare(strict_types=1);


namespace Ngcs\Core\ValueObjects;

use InvalidArgumentException;

/**
 * Class IpAddressValue
 * @package Ngcs\Core\ValueObjects
 */
abstract class IpAddressValue
{
    private string $value;

    /**
     * StringValue constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            throw new InvalidIp($value);
        }
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    public function getChunks(): array
    {
        return array_map(fn($a) => (int)$a, explode(".", $this->value));
    }

    public function getChunk(int $chunk): int
    {
        $chunks = $this->getChunks();
        if (!isset($chunks[$chunk])) {
            throw new InvalidArgumentException("Invalid chunk $chunk");
        }
        return $chunks[$chunk];
    }

    public function getHostIdentifier(): int
    {
        return $this->getChunk(3);
    }

    public function getNetworkPrefix(int $bits = 24): string
    {
        return (long2ip((ip2long($this->value)) & (ip2long($this->getSubNetMask($bits)))));
    }

    public function getSubNetMask(int $bits = 24): string
    {
        return (long2ip(ip2long("255.255.255.255") << (32 - $bits)));
    }

    public function getBroadcast(int $bits = 24): string
    {
        return (long2ip(ip2long($this->getNetworkPrefix($bits)) | (~(ip2long($this->getSubNetMask($bits))))));
    }
}