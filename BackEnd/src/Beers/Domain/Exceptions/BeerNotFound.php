<?php

namespace BeerApi\Shopping\Beers\Domain\Exceptions;

use Exception;
use Throwable;

/**
 * Class BeerNotFound
 * @package BeerApi\Shopping\Beers\Domain\Exceptions
 */
class BeerNotFound extends Exception
{
    public function __construct(string $message = "Beer has been not found", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}