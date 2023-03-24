<?php

namespace BeerApi\Shopping\Users\Infrastucture;

use BeerApi\Shopping\Users\Domain\Repositories\UsersRepository;
use BeerApi\Shopping\Users\Domain\User;
use BeerApi\Shopping\Users\Domain\ValueObject\UserId;
use PDOException;

/**
 *
 */
class MySQLUsersRepository implements UsersRepository
{

    public function insert(User $user): UserId
    {
        $db = Connection::access();
        try {
            $id = $user->getUserId()->getValue();
            $name = $user->getUserName()->getValue();
            $email = $user->getUserEmail()->getValue();
            $password = $user->getUserPassword()->getValue();
            $address = $user->getUserAddress()->getValue();
            $birth_date = $user->getUserBirthDate()->getValue();
            $phone = $user->getUserPhone()->getValue();
            $role = $user->getUserRole()->getValue();
            $sql = "insert into users(UUID,name,email,password,address,birth_date,phone,role) values ('$id','$name','$email','$password','$address',$birth_date,'$phone','$role') ";
            $result = $db->query($sql);
            if (!$result) {
                echo "Error: " . $db->errorInfo();
            }
            return $id;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        finally {
            $db = null;
        }
    }

    public function find(UserId $userId): User
    {
        // TODO: Implement find() method.
    }

    public function update(User $user): void
    {
        // TODO: Implement update() method.
    }

    public function delete(UserId $userId): void
    {
        $db = Connection::access();
        try {
            $id = $userId->getValue();
            $sql = "delete from users where UUID='$id'";
            $result = $db->query($sql);
            if (!$result) {
                echo "Error: " . $db->errorInfo();
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        finally {
            $db = null;
        }
    }

    public function findAll(string $field, int $prev_offset, int $next_offset): array
    {
        // TODO: Implement findAll() method.
    }
}