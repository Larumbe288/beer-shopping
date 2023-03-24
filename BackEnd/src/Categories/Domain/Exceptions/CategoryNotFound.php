<?php

namespace BeerApi\Shopping\Categories\Domain\Exceptions;

use Exception;
use Throwable;

class CategoryNotFound extends Exception
{

    public function __construct(string $message = "Category has been not found", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}