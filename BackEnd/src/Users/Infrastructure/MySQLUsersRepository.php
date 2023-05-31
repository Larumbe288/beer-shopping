<?php

namespace BeerApi\Shopping\Users\Infrastructure;

use BeerApi\Shopping\Connection\Doctrine;
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
use Doctrine\DBAL\Exception;

/**
 *
 */
class MySQLUsersRepository implements UsersRepository
{

    /**
     * @throws Exception
     */
    public function insert(User $user): UserId
    {
        $db = Doctrine::access();
        $id = $user->getUserId()->getValue();
        $name = $user->getUserName()->getValue();
        $email = $user->getUserEmail()->getValue();
        $password = password_hash($user->getUserPassword()->getValue(), PASSWORD_DEFAULT);
        $address = $user->getUserAddress()->getValue();
        $birth_date = $user->getUserBirthDate()->getValue();
        $phone = $user->getUserPhone()->getValue();
        $role = $user->getUserRole()->getValue();
        $db->insert('users')->values(array(
            'UUID' => ':id',
            'name' => ':name',
            'email' => ':email',
            'password' => ':password',
            'address' => ':address',
            'birth_date' => ':date',
            'phone' => ':phone',
            'role' => ':role'
        ))->setParameter(':id', $id)->setParameter(':name', $name)->setParameter(':email', $email)
            ->setParameter(':password', $password)
            ->setParameter(':address', $address)->setParameter(':date', $birth_date)
            ->setParameter(':phone', $phone)->setParameter(':role', $role)->execute();
        $db = null;
        return $user->getUserId();
    }

    /**
     * @throws Exception
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    public function find(UserId $userId): User
    {
        $db = Doctrine::access();
        $id = $userId->getValue();
        $result = $db->select('*')->from('users')->where('UUID = :id')
            ->setParameter(':id', $id)->execute()->fetchAllAssociative();
        $db = null;
        return $this->mapToUser($result)[0];
    }

    /**
     * @throws Exception
     */
    public function update(User $user): void
    {
        $id = $user->getUserId()->getValue();
        $email = $user->getUserEmail()->getValue();
        $address = $user->getUserAddress()->getValue();
        $birthDate = $user->getUserBirthDate()->getValue();
        $name = $user->getUserName()->getValue();
        $phone = $user->getUserPhone()->getValue();
        $db = Doctrine::access();
        $db->update('users')->where('UUID = :id')->setParameter(':id', $id)
            ->set('name', ':name')->setParameter(':name', $name)->set('email', ':email')->setParameter(':email', $email)
            ->set('address', ':address')->setParameter(':address', $address)->set('birth_date', ':date')->setParameter(':date', $birthDate)
            ->set('phone', ':phone')->setParameter(':phone', $phone)->execute();
        $db = null;
    }

    /**
     * @throws Exception
     */
    public function delete(UserId $userId): void
    {
        $db = Doctrine::access();
        $id = $userId->getValue();
        $db->delete('users')->where('UUID = :id')->setParameter(':id', $id)->execute();
        $db = null;
    }

    /**
     * @throws Exception
     * @throws \Doctrine\DBAL\Driver\Exception
     */
    public function findAll(string $field, int $prev_offset, int $next_offset): array
    {
        $db = Doctrine::access();
        $result = $db->select('*')->from('users')->orderBy($field, 'DESC')
            ->setFirstResult($prev_offset)->setMaxResults($next_offset)->execute()->fetchAllAssociative();
        $db = null;
        return $this->mapToUser($result);
    }

    /**
     * @param array $result
     * @return User[]
     */
    private function mapToUser(array $result): array
    {
        $arrayUsers = [];
        for ($i = 0; $i < count($result); $i++) {
            $id = $result[$i]['UUID'];
            $name = $result[$i]['name'];
            $email = $result[$i]['email'];
            $password = $result[$i]['password'];
            $address = $result[$i]['address'];
            $birth_date = $result[$i]['birth_date'];
            $phone = $result[$i]['phone'];
            $role = $result[$i]['role'];
            $arrayUsers[] = new User(new UserId($id), new UserName($name), new UserEmail($email), new UserPassword($password), new UserAddress($address),
                new UserBirthDate($birth_date), new UserPhone($phone), new UserRole($role));
        }
        return $arrayUsers;
    }

    public function updatePassword(UserId $userId, UserPassword $password): void
    {
        // TODO: Implement updatePassword() method.
    }
}