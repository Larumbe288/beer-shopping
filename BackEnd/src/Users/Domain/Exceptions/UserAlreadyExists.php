<?php

namespace BeerApi\Shopping\Users\Domain\Exceptions;

use Exception;
use Throwable;

class UserAlreadyExists extends Exception
{
    public function __construct(string $message = "This user already exists", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}