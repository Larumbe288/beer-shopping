<?php

namespace BeerShopping\App\Models\Users\Domain\ValueObject;

use InvalidArgumentException;

class UserPassword
{
    private string $password;

    public function __construct(string $password)
    {
        if (preg_match("/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/", $password)) {
            $this->password = $password;
        } else {
            throw new InvalidArgumentException();
        }
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->password;
    }
}