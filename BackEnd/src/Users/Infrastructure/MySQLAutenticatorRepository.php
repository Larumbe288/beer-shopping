<?php

namespace BeerApi\Shopping\Users\Infrastructure;

use BeerApi\Shopping\Connection\Doctrine;
use BeerApi\Shopping\Users\Application\DTOs\LoginDTO;
use BeerApi\Shopping\Users\Domain\Exceptions\UserNotFound;
use BeerApi\Shopping\Users\Domain\Repositories\AutenticatorRepository;
use BeerApi\Shopping\Users\Domain\ValueObject\UserEmail;
use BeerApi\Shopping\Users\Domain\ValueObject\UserId;
use BeerApi\Shopping\Users\Domain\ValueObject\UserPassword;
use Doctrine\DBAL\Exception;

/**
 * Class MySQLAutenticatorRepository
 * @package BeerApi\Shopping\Users\Infrastructure
 */
class MySQLAutenticatorRepository implements AutenticatorRepository
{

    /**
     * @param UserEmail $email
     * @param UserPassword $password
     * @return bool
     * @throws Exception
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws UserNotFound
     */
    public function adminLogin(UserEmail $email, UserPassword $password): bool
    {
        $emailValue = $email->getValue();
        $passwordValue = $password->getValue();
        $qb = Doctrine::access();
        $result = $qb->select('password')->from('users')
            ->where('email = :email')->andWhere('role = "admin"')
            ->setParameter(':email', $emailValue)
            ->execute()->fetchAllAssociative();
        if (!isset($result[0])) {
            throw new UserNotFound();
        }
        return password_verify($passwordValue, $result[0]['password']);
    }

    /**
     * @throws UserNotFound
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws Exception
     */
    public function userLogin(UserEmail $email, UserPassword $password): LoginDTO
    {
        $emailValue = $email->getValue();
        $passwordValue = $password->getValue();
        $qb = Doctrine::access();
        $result = $qb->select('password', 'UUID')->from('users')
            ->where('email = :email')
            ->setParameter(':email', $emailValue)
            ->execute()->fetchAllAssociative();
        if (!isset($result[0])) {
            throw new UserNotFound();
        }
        return new LoginDTO(password_verify($passwordValue, $result[0]['password']), new UserId($result[0]['UUID']));
    }

    public function adminRemember()
    {
        // TODO: Implement adminRemember() method.
    }

    public function userRemember()
    {
        // TODO: Implement userRemember() method.
    }
}