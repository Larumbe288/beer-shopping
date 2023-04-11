<?php

namespace Beer\Shopping\Test\Unit\Users;

use BeerApi\Shopping\Categories\Infrastucture\Repositories\InMemoryCategoryRepository;
use BeerApi\Shopping\Users\Application\UserCreator;
use BeerApi\Shopping\Users\Application\UserFinder;
use BeerApi\Shopping\Users\Application\UserUpdater;
use BeerApi\Shopping\Users\Domain\Exceptions\UserAlreadyExists;
use BeerApi\Shopping\Users\Domain\Exceptions\UserNotFound;
use BeerApi\Shopping\Users\Domain\User;
use BeerApi\Shopping\Users\Domain\ValueObject\UserAddress;
use BeerApi\Shopping\Users\Domain\ValueObject\UserBirthDate;
use BeerApi\Shopping\Users\Domain\ValueObject\UserEmail;
use BeerApi\Shopping\Users\Domain\ValueObject\UserId;
use BeerApi\Shopping\Users\Domain\ValueObject\UserName;
use BeerApi\Shopping\Users\Domain\ValueObject\UserPassword;
use BeerApi\Shopping\Users\Domain\ValueObject\UserPhone;
use BeerApi\Shopping\Users\Domain\ValueObject\UserRole;
use BeerApi\Shopping\Users\Infrastucture\InMemoryUsersRepository;
use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class UsersUnitTest extends TestCase
{

    private InMemoryUsersRepository $repository;
    private User $user;
    private UserName $name;
    private UserEmail $email;
    private UserPassword $password;
    private UserAddress $address;
    private UserBirthDate $birthDate;
    private UserPhone $phone;
    private UserRole $role;
    private UserId $id;

    public function testCreatingAnInvalidUserThrowsException()
    {
        self::expectException(InvalidArgumentException::class);
        $this->givenAnInvalidUser();
    }

    /**
     * @throws Exception
     */
    public function testUserIsCreatedAndSaved()
    {
        $this->givenAValidUser();
        $this->whenCreateUser();
        $this->thenUserIsSaved();
    }

    /**
     * @throws Exception
     */

    public function testUpdateNotExistingUserFails()
    {
        $this->givenACreatedUser();
        $this->givenAnInexistentId();
        $this->givenANewEmail();
        self::expectException(UserNotFound::class);
        $this->whenUpdateUser();
    }

    /**
     * @throws Exception
     */
    public function testUserUpdateFailsByDoubleEmail()
    {
        $this->givenACreatedUser();
        $this->givenANewDuplicatedEmail();
        self::expectException(UserAlreadyExists::class);
        $this->whenUpdateUser();
    }

    /**
     * @throws Exception
     */
    public function testUserUpdateIsSaved()
    {
        $this->givenACreatedUser();
        $this->givenANewEmail();
        $this->whenUpdateUser();
        $this->thenUserIsSaved();
    }

    private function givenAnInvalidUser()
    {
        $name = new UserName('');
    }

    private function givenAValidUser()
    {
        $this->user = User::randomUser();
        $this->repository = new InMemoryUsersRepository();
    }

    /**
     * @throws Exception
     */
    private function whenCreateUser()
    {
        $creator = new UserCreator($this->repository);
        $this->name = $this->user->getUserName();
        $this->email = $this->user->getUserEmail();
        $this->password = $this->user->getUserPassword();
        $this->address = $this->user->getUserAddress();
        $this->birthDate = $this->user->getUserBirthDate();
        $this->phone = $this->user->getUserPhone();
        $this->role = $this->user->getUserRole();
        $this->id = $creator->__invoke($this->name, $this->email, $this->password, $this->address, $this->birthDate, $this->phone, $this->role);
    }

    private function thenUserIsSaved()
    {
        $finder = new UserFinder($this->repository);
        $user = new User($this->id, $this->name, $this->email, $this->password, $this->address, $this->birthDate, $this->phone, $this->role);
        self::assertEquals($user, $finder->__invoke($this->id));
    }

    /**
     * @throws Exception
     */
    private function givenACreatedUser()
    {
        $this->testUserIsCreatedAndSaved();
    }

    private function givenANewDuplicatedEmail()
    {
        $this->name = new UserName($this->user->getUserName()->getValue());
    }

    private function whenUpdateUser()
    {
        $updater = new UserUpdater($this->repository);
        $user = new User($this->id, $this->name, $this->email, $this->password, $this->address, $this->birthDate, $this->phone, $this->role);
        $updater->__invoke($user);
    }

    /**
     * @throws Exception
     */
    private function givenANewEmail()
    {
        $this->email = new UserEmail('alvaro@larumbe.es');
    }

    /**
     * @throws Exception
     */
    private function givenAnInexistentId()
    {
        $this->id = UserId::generate();
    }

}