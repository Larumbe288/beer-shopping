<?php

namespace BeerApi\Shopping\Users\Domain\ValueObject;

use Faker\Factory;
use InvalidArgumentException;

/**
 * Class UserBirthDate
 * @package BeerApi\Shopping\Users\Domain\ValueObject
 */
class UserBirthDate
{
    private string $date;

    public function __construct(string $date)
    {
        if (preg_match("/^\d{4}\-(0?[1-9]|1[012])\-(0?[1-9]|[12][0-9]|3[01])$/",
            $date)) {
            $this->date = $date;
        } else {
            throw new InvalidArgumentException();
        }
    }

    public static function randomDate(): UserBirthDate
    {
        $faker = Factory::create();
        $date = $faker->date();
        return new UserBirthDate($date);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->date;
    }
}

