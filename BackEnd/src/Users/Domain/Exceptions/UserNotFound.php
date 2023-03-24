<?php

namespace BeerApi\Shopping\Users\Domain\Exceptions;

use Exception;
use Throwable;

class UserNotFound extends Exception
{
    public function __construct(string $message = "User has not been found", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}