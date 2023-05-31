<?php

namespace BeerApi\Shopping\Beers\Domain\ValueObject;

use Faker\Factory;
use Ngcs\Core\ValueObjects\StringValue;

/**
 * Class BeerCountry
 * @package BeerApi\Shopping\Beers\Domain\ValueObject
 */
class BeerCountry extends StringValue
{

    public static function randomCountry(): BeerCountry
    {
        $faker = Factory::create();
        $country = $faker->country;
        return new self($country);
    }
}