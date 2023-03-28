<?php

namespace BeerApi\Shopping\Users\Domain\ValueObject;

use Faker\Factory;
use InvalidArgumentException;

class UserEmail
{
    private string $email;

    public function __construct(string $email)
    {
        if (preg_match("/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/", $email)) {
            $this->email = $email;
        } else {
            throw new InvalidArgumentException();
        }
    }

    public static function randomEmail(): UserEmail
    {
        $faker = Factory::create();
        $email = $faker->email();
        return new UserEmail($email);
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->email;
    }
}