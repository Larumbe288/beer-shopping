<?php

namespace BeerApi\Shopping\Users\Domain\ValueObject;

use InvalidArgumentException;

class UserName
{
    private string $name;

    public function __construct(string $name)
    {
        if (strlen($name) < 8 || strlen($name) > 255) {
            throw new InvalidArgumentException();
        }
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->name;
    }
}