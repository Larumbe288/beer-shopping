<?php

namespace BeerApi\Shopping\Beers\Domain\ValueObject;

use Faker\Factory;
use Ngcs\Core\ValueObjects\StringValue;

/**
 * Class BeerCity
 * @package BeerApi\Shopping\Beers\Domain\ValueObject
 */
class BeerCity extends StringValue
{
    public static function randomCity(): self
    {
        $faker = Factory::create();
        $city = $faker->city;
        return new self($city);
    }
}