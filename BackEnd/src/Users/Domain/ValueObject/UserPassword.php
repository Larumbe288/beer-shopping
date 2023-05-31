<?php

namespace BeerApi\Shopping\Users\Domain\ValueObject;

use Faker\Factory;
use InvalidArgumentException;

/**
 * Class UserPassword
 * @package BeerApi\Shopping\Users\Domain\ValueObject
 */
class UserPassword
{
    private string $password;

    public function __construct(string $password)
    {
        if (preg_match("/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[a-z]).*$/", $password)) {
            $this->password = $password;
        } else {
            throw new InvalidArgumentException();
        }
        $this->password = $password;
    }

    public static function randomPassword(): UserPassword
    {
        $faker = Factory::create();
        $password = $faker->password(8, 15);
        return new UserPassword($password);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->password;
    }
}