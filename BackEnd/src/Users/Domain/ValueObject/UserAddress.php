<?php

namespace BeerApi\Shopping\Users\Domain\ValueObject;

use Faker\Factory;
use InvalidArgumentException;

/**
 * Class UserAddress
 * @package BeerApi\Shopping\Users\Domain\ValueObject
 */
class UserAddress
{
    private string $address;

    public function __construct(string $address)
    {
        if (strlen($address) < 15 || strlen($address) > 255) {
            throw new InvalidArgumentException();
        }
        $this->address = $address;
    }

    /**
     * @return UserAddress
     */
    public static function randomAddress(): UserAddress
    {
        $faker = Factory::create();
        $address = $faker->address();
        return new UserAddress($address);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->address;
    }
}