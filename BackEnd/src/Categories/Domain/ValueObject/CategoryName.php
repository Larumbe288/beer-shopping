<?php

namespace BeerApi\Shopping\Categories\Domain\ValueObject;

use Faker\Factory;
use InvalidArgumentException;
use Ngcs\Core\ValueObjects\StringValue;

/**
 *
 */
class CategoryName extends StringValue
{
    public function __construct(string $value)
    {
        if (strlen($value) > 70) {
            throw new InvalidArgumentException();
        }
        parent::__construct($value);
    }

    public static function randomName(): self
    {
        $faker = Factory::create();
        $name = $faker->name();
        return new CategoryName($name);
    }

}