<?php

namespace BeerShopping\App\Models\Users\Domain;

use BeerShopping\App\Models\Users\Domain\ValueObject\UserAddress;
use BeerShopping\App\Models\Users\Domain\ValueObject\UserBirthDate;
use BeerShopping\App\Models\Users\Domain\ValueObject\UserEmail;
use BeerShopping\App\Models\Users\Domain\ValueObject\UserId;
use BeerShopping\App\Models\Users\Domain\ValueObject\UserName;
use BeerShopping\App\Models\Users\Domain\ValueObject\UserPassword;
use BeerShopping\App\Models\Users\Domain\ValueObject\UserPhone;

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