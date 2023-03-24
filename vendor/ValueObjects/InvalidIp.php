<?php
declare(strict_types=1);


namespace Ngcs\Core\ValueObjects;

use Exception;
use Throwable;

/**
 * Class InvalidIp
 * @package Ngcs\Core\ValueObjects
 */
final class InvalidIp extends Exception
{

    public function __construct(string $ip, Throwable $previous = null)
    {
        parent::__construct("Wrong IP $ip", 0, $previous);
    }
}