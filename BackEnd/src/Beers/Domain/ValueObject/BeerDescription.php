<?php

namespace BeerApi\Shopping\Beers\Domain\ValueObject;

use Faker\Factory;
use Ngcs\Core\ValueObjects\StringValue;

/**
 * Class BeerDescription
 * @package BeerApi\Shopping\Beers\Domain\ValueObject
 */
class BeerDescription extends StringValue
{
    public static function randomDescription(): BeerDescription
    {
        $faker = Factory::create();
        return new self($faker->text);
    }
}