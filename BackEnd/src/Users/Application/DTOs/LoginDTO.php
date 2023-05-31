<?php

namespace BeerApi\Shopping\Users\Application\DTOs;

use BeerApi\Shopping\Users\Domain\ValueObject\UserId;
use JsonSerializable;

/**
 * Class LoginDTO
 * @package BeerApi\Shopping\Users\Application\DTOs
 */
class LoginDTO implements JsonSerializable
{
    private bool $login;
    private UserId $id;

    public function __construct(bool $login, UserId $id)
    {
        $this->login = $login;
        $this->id = $id;
    }

    public function jsonSerialize(): mixed
    {
        return array(
            "login" => $this->login,
            "id" => $this->id->getValue()
        );
    }
}