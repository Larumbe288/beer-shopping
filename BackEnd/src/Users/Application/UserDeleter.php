<?php

namespace BeerApi\Shopping\Users\Application;

use BeerApi\Shopping\Users\Domain\Repositories\UsersRepository;
use BeerApi\Shopping\Users\Domain\ValueObject\UserId;

/**
 *
 */
class UserDeleter
{
    private UsersRepository $usersRepository;

    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function __invoke(UserId $userId): void
    {
        $user = $this->usersRepository->find($userId);
        $user->delete();
        $this->usersRepository->delete($user->getUserId());
    }
}