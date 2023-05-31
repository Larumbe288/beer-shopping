<?php

namespace BeerApi\Shopping\Sales\Domain\Exceptions;

use Exception;
use Throwable;

/**
 * Class SalesNotFound
 * @package BeerApi\Shopping\Sales\Domain\Exceptions
 */
class SalesNotFound extends Exception
{
    public function __construct(string $message = "Sale has been not found", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}