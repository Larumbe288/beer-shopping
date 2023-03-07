<?php

namespace BeerShopping\App\Models\Users\Domain\Repositories;

use BeerShopping\App\Models\Users\Domain\ValueObject\UserEmail;
use BeerShopping\App\Models\Users\Domain\ValueObject\UserPassword;
use BeerShopping\App\Models\Users\Domain\ValueObject\UserRole;

interface AutenticatorRepository
{
    public function adminLogin(UserEmail $email, UserPassword $password);

    public function userLogin();

    public function adminRemember();

    public function userRemember();
}