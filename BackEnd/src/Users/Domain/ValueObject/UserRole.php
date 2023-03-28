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

    public static function randomRole(): UserRole
    {
        $random = rand(0, 1);
        if ($random === 0) {
            return new UserRole('admin');
        } else {
            return new UserRole('user');
        }
    }

    public function getValue()
    {
        return $this->role;
    }
}