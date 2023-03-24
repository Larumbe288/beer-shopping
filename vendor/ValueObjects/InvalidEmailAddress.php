<?php
declare(strict_types=1);

namespace Ngcs\Core\ValueObjects;

use Exception;
use Throwable;

/**
 * Class InvalidEmailAddress
 * @package Ngcs\Core\ValueObjects
 */
final class InvalidEmailAddress extends Exception
{
    /**
     * @param string $emailAddress
     * @param Throwable|null $previous
     */
    public function __construct(string $emailAddress, Throwable $previous = null)
    {
        parent::__construct("Invalid email address $emailAddress", 0, $previous);
    }
}
