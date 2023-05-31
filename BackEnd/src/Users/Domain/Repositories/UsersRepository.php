<?php

namespace BeerApi\Shopping\Users\Domain\Repositories;

use BeerApi\Shopping\Categories\Domain\Category;
use BeerApi\Shopping\Users\Domain\User;
use BeerApi\Shopping\Users\Domain\ValueObject\UserId;
use BeerApi\Shopping\Users\Domain\ValueObject\UserPassword;

/**
 * @author Álvaro Larumbe
 * @version 1.0
 * This interface will be used for inverting dependencies when persisting users
 * It can be implemented in any database and also in memory
 */
interface UsersRepository
{
    /**
     * @param User $user
     * @return UserId
     */
    public function insert(User $user): UserId;

    /**
     * @param UserId $userId
     * @return User
     */
    public function find(UserId $userId): User;

    /**
     * @param User $user
     * @return void
     */
    public function update(User $user): void;

    /**
     * @param UserId $userId
     * @return void
     */
    public function delete(UserId $userId): void;

    /**
     * @param string $field
     * @param int $prev_offset
     * @param int $next_offset
     * @return Category[]
     */
    public function findAll(string $field, int $prev_offset, int $next_offset): array;

    public function updatePassword(UserId $userId, UserPassword $password): void;
}