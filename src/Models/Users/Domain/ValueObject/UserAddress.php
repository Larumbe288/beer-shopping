<?php

namespace BeerShopping\App\Models\Users\Domain\ValueObject;

use InvalidArgumentException;

class UserAddress
{
    private string $address;

    public function __construct(string $address)
    {
        if (strlen($address) < 25 || strlen($address) > 255) {
            throw new InvalidArgumentException();
        }
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->address;
    }
}