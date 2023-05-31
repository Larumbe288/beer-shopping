<?php

namespace BeerApi\Shopping\Beers\Domain\ValueObject;

use Faker\Factory;
use Ngcs\Core\ValueObjects\StringValue;

/**
 * Class BeerName
 * @package BeerApi\Shopping\Beers\Domain\ValueObject
 */
class BeerName extends StringValue
{
    public static function randomName()
    {
        $faker = Factory::create();
        return new self($faker->name);
    }
}