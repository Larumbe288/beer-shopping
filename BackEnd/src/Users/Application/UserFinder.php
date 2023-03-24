<?php

namespace BeerApi\Shopping\Users\Application;

use BeerApi\Shopping\Users\Domain\Repositories\UsersRepository;
use BeerApi\Shopping\Users\Domain\User;
use BeerApi\Shopping\Users\Domain\ValueObject\UserId;

class UserFinder
{
    private UsersRepository $usersRepository;

    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function __invoke(UserId $userId): User
    {
        return $this->usersRepository->find($userId);
    }
}