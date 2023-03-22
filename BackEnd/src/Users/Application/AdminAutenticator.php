<?php

namespace BeerApi\Shopping\Users\Application;

use BeerApi\Shopping\Users\Domain\Repositories\AutenticatorRepository;
use BeerApi\Shopping\Users\Domain\ValueObject\UserEmail;
use BeerApi\Shopping\Users\Domain\ValueObject\UserPassword;

class AdminAutenticator
{
    private AutenticatorRepository $repository;

    public function __construct(AutenticatorRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(UserEmail $email, UserPassword $password)
    {
        return $this->repository->adminLogin($email, $password);
    }
}