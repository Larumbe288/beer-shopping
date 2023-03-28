<?php

namespace BeerApi\Shopping\Users\Domain;

use BeerApi\Shopping\Users\Domain\ValueObject\UserAddress;
use BeerApi\Shopping\Users\Domain\ValueObject\UserBirthDate;
use BeerApi\Shopping\Users\Domain\ValueObject\UserEmail;
use BeerApi\Shopping\Users\Domain\ValueObject\UserId;
use BeerApi\Shopping\Users\Domain\ValueObject\UserName;
use BeerApi\Shopping\Users\Domain\ValueObject\UserPassword;
use BeerApi\Shopping\Users\Domain\ValueObject\UserPhone;
use BeerApi\Shopping\Users\Domain\ValueObject\UserRole;
use Exception;
use InvalidArgumentException;
use JsonSerializable;

class User implements JsonSerializable
{
    private UserId $userId;
    private UserName $userName;
    private UserEmail $userEmail;
    private UserPassword $userPassword;
    private UserAddress $userAddress;
    private UserBirthDate $userBirthDate;
    private UserPhone $userPhone;
    private UserRole $userRole;

    public function __construct(
        UserId $userId,
        UserName $userName,
        UserEmail $userEmail,
        UserPassword $userPassword,
        UserAddress $userAddress,
        UserBirthDate $userBirthDate,
        UserPhone $userPhone,
        UserRole $userRole
    ) {
        $this->userId = $userId;
        $this->userName = $userName;
        $this->userEmail = $userEmail;
        $this->userPassword = $userPassword;
        $this->userAddress = $userAddress;
        $this->userBirthDate = $userBirthDate;
        $this->userPhone = $userPhone;
        $this->userRole = $userRole;
    }

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return UserName
     */
    public function getUserName(): UserName
    {
        return $this->userName;
    }

    /**
     * @return UserEmail
     */
    public function getUserEmail(): UserEmail
    {
        return $this->userEmail;
    }

    /**
     * @return UserPassword
     */
    public function getUserPassword(): UserPassword
    {
        return $this->userPassword;
    }

    /**
     * @return UserAddress
     */
    public function getUserAddress(): UserAddress
    {
        return $this->userAddress;
    }

    /**
     * @return UserBirthDate
     */
    public function getUserBirthDate(): UserBirthDate
    {
        return $this->userBirthDate;
    }

    /**
     * @return UserPhone
     */
    public function getUserPhone(): UserPhone
    {
        return $this->userPhone;
    }

    /**
     * @param UserName $name
     * @param UserEmail $email
     * @param UserPassword $password
     * @param UserAddress $address
     * @param UserBirthDate $birthDate
     * @param UserPhone $phone
     * @throws Exception
     */
    public static function create(
        UserName $name,
        UserEmail $email,
        UserPassword $password,
        UserAddress $address,
        UserBirthDate $birthDate,
        UserPhone $phone,
        UserRole $role
    ): self {
        $id = UserId::generate();
        return new User($id, $name, $email, $password, $address, $birthDate, $phone, $role);
    }

    public static function randomUser(): User
    {
        return new User(UserId::generate(), UserName::randomName(), UserEmail::randomEmail(), UserPassword::randomPassword(), UserAddress::randomAddress(),
            UserBirthDate::randomDate(), UserPhone::randomPhone(), UserRole::randomRole());
    }

    /**
     * @return UserRole
     */
    public function getUserRole(): UserRole
    {
        return $this->userRole;
    }

    public function autenticate()
    {

    }

    public function update(UserName $name, UserEmail $email, UserPassword $password, UserAddress $address, UserBirthDate $birthDate, UserPhone $phone, UserRole $role): self
    {
        $this->userName = $name;
        $this->userEmail = $email;
        $this->userPassword = $password;
        $this->userAddress = $address;
        $this->userBirthDate = $birthDate;
        $this->userPhone = $phone;
        $this->userRole = $role;
        return $this;
    }

    public function delete(): void
    {
        if ($this->hasPendingProducts() || $this->isAdmin()) {
            throw new InvalidArgumentException();
        }
    }

    private function hasPendingProducts(): bool
    {
        return false;
    }

    private function isAdmin(): bool
    {
        return false;
    }

    /**
     * @return mixed
     */
    public function jsonSerialize(): mixed
    {
        return array(
            "id" => $this->getUserId()->getValue(),
            "properties" => array(
                "name" => $this->userName->getValue(),
                "email" => $this->userEmail->getValue(),
                "password" => $this->userPassword->getValue(),
                "address" => $this->userAddress->getValue(),
                "birth_date" => $this->userBirthDate->getValue(),
                "phone" => $this->userPhone->getValue(),
                "role" => $this->userRole->getValue()
            )
        );
    }
}