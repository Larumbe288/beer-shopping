<?php

namespace BeerApi\Shopping\Users\Domain\Repositories;

use BeerApi\Shopping\Users\Application\DTOs\LoginDTO;
use BeerApi\Shopping\Users\Domain\ValueObject\UserEmail;
use BeerApi\Shopping\Users\Domain\ValueObject\UserPassword;

/**
 * Interface AutenticatorRepository
 * @package BeerApi\Shopping\Users\Domain\Repositories
 */
interface AutenticatorRepository
{
    public function adminLogin(UserEmail $email, UserPassword $password): bool;

    public function userLogin(UserEmail $email, UserPassword $password): LoginDTO;

    public function adminRemember();

    public function userRemember();
}