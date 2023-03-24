<?php

namespace BeerApi\Shopping\Users\Infrastucture;

use BeerApi\Shopping\Users\Domain\Exceptions\UserAlreadyExists;
use BeerApi\Shopping\Users\Domain\Exceptions\UserNotFound;
use BeerApi\Shopping\Users\Domain\User;
use BeerApi\Shopping\Users\Domain\ValueObject\UserEmail;
use BeerApi\Shopping\Users\Domain\ValueObject\UserId;

class InMemoryUsersRepository implements \BeerApi\Shopping\Users\Domain\Repositories\UsersRepository
{
    /** @var User[] */
    private array $memory;

    public function __construct()
    {
        $this->memory = [];
    }

    /**
     * @inheritDoc
     */
    public function insert(User $user): UserId
    {
        $this->checkEmail();
        $this->memory = $this->array_push_assoc($this->memory, $user->getUserId(), $user);
        return $user->getUserId();
    }

    /**
     * @inheritDoc
     * @throws UserNotFound
     */
    public function find(UserId $userId): User
    {
        if (!isset($this->memory[$userId->getValue()])) {
            throw new UserNotFound();
        }
        return clone $this->memory[$userId->getValue()];
    }

    /**
     * @inheritDoc
     * @throws UserNotFound
     */
    public function update(User $user): void
    {
        if (!isset($this->memory[$user->getUserId()->getValue()])) {
            throw new UserNotFound();
        }
        $this->memory[$user->getUserId()->getValue()] = $user;
    }

    /**
     * @inheritDoc
     * @throws UserNotFound
     */
    public function delete(UserId $userId): void
    {
        if (!isset($this->memory[$userId->getValue()])) {
            throw new UserNotFound();
        }
        unset($this->memory[$userId->getValue()]);
    }

    /**
     * @inheritDoc
     */
    public function findAll(string $field, int $prev_offset, int $next_offset): array
    {
        return $this->memory;
    }

    /**
     * @param array $array
     * @param UserId $key
     * @param User $value
     * @return array
     */
    private function array_push_assoc(array $array, UserId $key, User $value): array
    {
        $array[$key->getValue()] = $value;
        return $array;
    }

    private function checkEmail(UserEmail $userEmail)
    {
        foreach ($this->memory as $key=>$value) {
            if($userEmail->getValue() === $value->getUserEmail()->getValue()) {
                throw new UserAlreadyExists();
            }
        }
    }
}