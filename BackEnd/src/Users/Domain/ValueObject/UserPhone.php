<?php

namespace BeerApi\Shopping\Users\Domain\ValueObject;

use Faker\Factory;
use InvalidArgumentException;

class UserPhone
{
    private string $phone;

    public function __construct(string $phone)
    {
        $phone = str_replace(' ', '', $phone);
        if (preg_match("/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/", $phone)) {
            $this->phone = $phone;
        } else {
            throw new InvalidArgumentException();
        }
    }

    public static function randomPhone()
    {
        $faker = Factory::create();
        $phone = $faker->phoneNumber();
        return new UserPhone($phone);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->phone;
    }
}