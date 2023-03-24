<?php
declare(strict_types=1);


namespace Ngcs\Core\ValueObjects;


/**
 * Class IpSubnetValue
 * @package Ngcs\Core\ValueObjects
 */
abstract class IpSubnetValue
{
    private string $value;
    private string $networkPrefix;
    private int $bits;

    /**
     * StringValue constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        if (empty(preg_match("/^\d+\.\d+\.\d+\.\d+\/\d+$/", $value))) {
            throw new InvalidIpSubnet($value);
        }
        [$networkPrefix, $bits] = explode("/", $value);
        $this->bits = (int)$bits;
        if (!filter_var($networkPrefix, FILTER_VALIDATE_IP) || (($this->bits < 24) || ($this->bits > 32))) {
            throw new InvalidIpSubnet($value);
        }
        if (((int)(explode(".", $networkPrefix)[3])) + (2 ** (32 - $this->bits)) > 256) {
            throw new InvalidIpSubnet($value);
        }
        $this->networkPrefix = $networkPrefix;
        $this->value = $value;
    }


    public function checkIpBelongs(IpAddressValue $ipAddress): bool
    {

        $broadcast = ip2long($this->getBroadcast());
        $subnetMask = ip2long($this->getSubNetMask());
        $netMask = $broadcast & $subnetMask;
        return ((ip2long($ipAddress->getValue()) & $subnetMask) == ($netMask & $subnetMask));

    }

    public function getFirstHostAddress(): string
    {
        return long2ip(ip2long($this->getNetworkPrefix()) + 1);
    }

    public function getLastHostAddress(): string
    {
        return long2ip(ip2long($this->getNetworkPrefix()) + ((1 << (32 - $this->getBits())) - 2));
    }


    public function getBits(): int
    {
        return $this->bits;
    }


    public function getNetworkPrefix(): string
    {
        return $this->networkPrefix;
    }

    public function getSubNetMask(): string
    {
        return (long2ip(ip2long("255.255.255.255") << (32 - $this->getBits())));
    }

    public function getBroadcast(): string
    {
        return (long2ip(ip2long($this->getNetworkPrefix()) | (~(ip2long($this->getSubNetMask())))));
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}