<?php

namespace BeerApi\Shopping\Users\Domain;

use BeerApi\Shopping\Users\Domain\ValueObject\UserAddress;
use BeerApi\Shopping\Users\Domain\ValueObject\UserBirthDate;
use BeerApi\Shopping\Users\Domain\ValueObject\UserEmail;
use BeerApi\Shopping\Users\Domain\ValueObject\UserId;
use BeerApi\Shopping\Users\Domain\ValueObject\UserName;
use BeerApi\Shopping\Users\Domain\ValueObject\UserPassword;
use BeerApi\Shopping\Users\Domain\ValueObject\UserPhone;

class User
{
    private UserId $userId;
    private UserName $userName;
    private UserEmail $userEmail;
    private UserPassword $userPassword;
    private UserAddress $userAddress;
    private UserBirthDate $userBirthDate;
    private UserPhone $userPhone;

    public function __construct(
        UserId $userId,
        UserName $userName,
        UserEmail $userEmail,
        UserPassword $userPassword,
        UserAddress $userAddress,
        UserBirthDate $userBirthDate,
        UserPhone $userPhone
    ) {
        $this->userId = $userId;
        $this->userName = $userName;
        $this->userEmail = $userEmail;
        $this->userPassword = $userPassword;
        $this->userAddress = $userAddress;
        $this->userBirthDate = $userBirthDate;
        $this->userPhone = $userPhone;
    }

    public function autenticate()
    {

    }
}