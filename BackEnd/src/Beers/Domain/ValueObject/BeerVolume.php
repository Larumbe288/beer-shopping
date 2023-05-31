<?php

namespace BeerApi\Shopping\Beers\Domain\ValueObject;

use Faker\Factory;
use Ngcs\Core\ValueObjects\IntValue;

/**
 * Class BeerVolume
 * @package BeerApi\Shopping\Beers\Domain\ValueObject
 */
class BeerVolume extends IntValue
{
    public static function randomVolume(): BeerVolume
    {
        $faker = Factory::create();
        $volume = $faker->randomDigit();
        return new self($volume);
    }
}