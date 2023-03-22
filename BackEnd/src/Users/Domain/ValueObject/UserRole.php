<?php

namespace BeerApi\Shopping\Users\Domain\ValueObject;

use InvalidArgumentException;

class UserRole
{
    private string $role;

    public function __construct(string $role)
    {
        if ($role !== "admin" && $role !== "user") {
            throw new InvalidArgumentException();
        }
        $this->role = $role;
    }
}