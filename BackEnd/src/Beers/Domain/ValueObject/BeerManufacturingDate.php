<?php

namespace BeerApi\Shopping\Beers\Domain\ValueObject;

use Faker\Factory;
use Ngcs\Core\ValueObjects\StringValue;

/**
 * Class BeerManufacturingDate
 * @package BeerApi\Shopping\Beers\Domain\ValueObject
 */
class BeerManufacturingDate extends StringValue
{
    public static function randomDate()
    {
        $faker = Factory::create();
        return new self($faker->date);
    }
}