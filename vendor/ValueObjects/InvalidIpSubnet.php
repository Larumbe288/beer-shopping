<?php
declare(strict_types=1);


namespace Ngcs\Core\ValueObjects;

use Exception;
use Throwable;

/**
 * Class InvalidIpSubnet
 * @package Ngcs\Core\ValueObjects
 */
final class InvalidIpSubnet extends Exception
{

    public function __construct(string $subnet, Throwable $previous = null)
    {
        parent::__construct("Wrong subnet $subnet", 0, $previous);
    }
}