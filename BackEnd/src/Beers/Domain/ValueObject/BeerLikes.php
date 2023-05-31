<?php

namespace BeerApi\Shopping\Beers\Domain\ValueObject;

use Faker\Factory;
use Ngcs\Core\ValueObjects\IntValue;

/**
 * Class BeerLikes
 * @package BeerApi\Shopping\Beers\Domain\ValueObject
 */
class BeerLikes extends IntValue
{
    public static function randomLikes()
    {
        $faker = Factory::create();
        return new self($faker->randomDigit());
    }
}