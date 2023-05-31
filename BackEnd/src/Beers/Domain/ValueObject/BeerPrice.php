<?php

namespace BeerApi\Shopping\Beers\Domain\ValueObject;

use Faker\Factory;
use Ngcs\Core\ValueObjects\FloatValue;

/**
 * Class BeerPrice
 * @package BeerApi\Shopping\Beers\Domain\ValueObject
 */
class BeerPrice extends FloatValue
{
    public static function randomPrice()
    {
        $faker = Factory::create();
        $price = $faker->randomFloat(2, 0, 3);
        return new self($price);
    }
}