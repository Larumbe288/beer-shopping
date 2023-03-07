<?php

namespace BeerShopping\App\Models\Users\Application;

use BeerShopping\App\Models\Users\Domain\Repositories\AutenticatorRepository;
use BeerShopping\App\Models\Users\Domain\ValueObject\UserEmail;
use BeerShopping\App\Models\Users\Domain\ValueObject\UserPassword;

class AdminAutenticator
{
    private AutenticatorRepository $repository;

    public function __construct(AutenticatorRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(UserEmail $email, UserPassword $password)
    {
        $this->repository->adminLogin($email, $password);
    }
}