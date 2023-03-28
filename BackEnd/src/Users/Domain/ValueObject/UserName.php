<?php

namespace BeerApi\Shopping\Users\Domain\ValueObject;

use Faker\Factory;
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

    public static function randomName(): UserName
    {
        $faker = Factory::create();
        $name = $faker->name();
        return new UserName($name);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->name;
    }
}