<?php

namespace BeerShopping\App\Models\Users\Domain\ValueObject;

use InvalidArgumentException;

class UserPhone
{
    private string $phone;

    public function __construct(string $phone)
    {
        if (preg_match("/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/", $phone)) {
            $this->phone = $phone;
        } else {
            throw new InvalidArgumentException();
        }
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->phone;
    }
}