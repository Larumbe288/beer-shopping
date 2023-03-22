<?php

namespace BeerApi\Shopping\Users\Domain\Repositories;

use BeerApi\Shopping\Users\Domain\ValueObject\UserEmail;
use BeerApi\Shopping\Users\Domain\ValueObject\UserPassword;

interface AutenticatorRepository
{
    public function adminLogin(UserEmail $email, UserPassword $password);

    public function userLogin();

    public function adminRemember();

    public function userRemember();
}