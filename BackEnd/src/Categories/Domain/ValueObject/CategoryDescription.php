<?php

namespace BeerApi\Shopping\Categories\Domain\ValueObject;

use Faker\Factory;
use InvalidArgumentException;
use Ngcs\Core\ValueObjects\StringValue;

/**
 *
 */
class CategoryDescription extends StringValue
{
    public function __construct(string $value)
    {
        if (strlen($value < 70)) {
            throw new InvalidArgumentException();
        }
        parent::__construct($value);
    }

    public static function randomDescription(): CategoryDescription
    {
        $faker = Factory::create();
        $text = $faker->text(70);
        return new CategoryDescription($text);
    }

}