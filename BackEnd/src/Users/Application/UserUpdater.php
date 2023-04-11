<?php

namespace BeerApi\Shopping\Users\Application;

use BeerApi\Shopping\Users\Domain\Repositories\UsersRepository;
use BeerApi\Shopping\Users\Domain\User;

class UserUpdater
{
    private UsersRepository $usersRepository;

    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function __invoke(User $user): void
    {
        $user2 = $this->usersRepository->find($user->getUserId());
        $name = $user->getUserName();
        $email = $user->getUserEmail();
        $password = $user->getUserPassword();
        $address = $user->getUserAddress();
        $birthDate = $user->getUserBirthDate();
        $phone = $user->getUserPhone();
        $role = $user->getUserRole();
        $user->update($name, $email, $password, $address, $birthDate, $phone, $role);
        $this->usersRepository->update($user);
    }
}