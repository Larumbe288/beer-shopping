<?php

namespace BeerApi\Shopping\Users\Application;

use BeerApi\Shopping\Users\Domain\Repositories\UsersRepository;
use BeerApi\Shopping\Users\Domain\User;
use BeerApi\Shopping\Users\Domain\ValueObject\UserAddress;
use BeerApi\Shopping\Users\Domain\ValueObject\UserBirthDate;
use BeerApi\Shopping\Users\Domain\ValueObject\UserEmail;
use BeerApi\Shopping\Users\Domain\ValueObject\UserId;
use BeerApi\Shopping\Users\Domain\ValueObject\UserName;
use BeerApi\Shopping\Users\Domain\ValueObject\UserPassword;
use BeerApi\Shopping\Users\Domain\ValueObject\UserPhone;
use BeerApi\Shopping\Users\Domain\ValueObject\UserRole;
use Exception;

class UserCreator
{
    private UsersRepository $usersRepository;

    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    /**
     * @throws Exception
     */
    public function __invoke(
        UserName $name,
        UserEmail $email,
        UserPassword $password,
        UserAddress $address,
        UserBirthDate $birthDate,
        UserPhone $phone,
        UserRole $role
    ): UserId {
        $user = User::create($name, $email, $password, $address, $birthDate, $phone, $role);
        $this->usersRepository->create($user);
        return $user->getUserId();
    }
}