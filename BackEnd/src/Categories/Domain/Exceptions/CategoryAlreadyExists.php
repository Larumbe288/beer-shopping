<?php

namespace BeerApi\Shopping\Categories\Domain\Exceptions;

use Exception;
use Throwable;

class CategoryAlreadyExists extends Exception
{
    public function __construct(string $message = "This category already exists", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}