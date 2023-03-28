<?php

namespace BeerApi\Shopping\Users\Infrastucture;

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
            $password = sha1($user->getUserPassword()->getValue());
            $address = $user->getUserAddress()->getValue();
            $birth_date = $user->getUserBirthDate()->getValue();
            $phone = $user->getUserPhone()->getValue();
            $role = $user->getUserRole()->getValue();
            $sql = "insert into users(UUID,name,email,password,address,birth_date,phone,role) values ('$id','$name','$email','$password','$address',STR_TO_DATE('$birth_date', '%Y-%m-%d'),'$phone','$role') ";
            $result = $db->query($sql);
            if (!$result) {
                echo "Error: " . $db->errorInfo();
            }
            return $user->getUserId();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        finally {
            $db = null;
        }
    }

    public function find(UserId $userId): User
    {
        $db = Connection::access();
        try {
            $id = $userId->getValue();
            $sql = "select UUID,name,email,password,address,birth_date,phone,role from users where UUID='$id'";
            $result = $db->query($sql);
            $user = $result->fetch();
            if ($user) {
                return new User(new UserId($user['UUID']), new UserName($user['name']), new UserEmail($user['email']), new UserPassword($user['password']),
                    new UserAddress($user['address']), new UserBirthDate($user['birth_date']),
                    new UserPhone($user['phone']), new UserRole($user['role']));
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        finally {
            $db = null;
        }
    }

    public function update(User $user): void
    {
        $id = $user->getUserId()->getValue();
        $email = $user->getUserEmail()->getValue();
        $address = $user->getUserAddress()->getValue();
        $birthDate = $user->getUserBirthDate()->getValue();
        $name = $user->getUserName()->getValue();
        $phone = $user->getUserPhone()->getValue();
        $db = Connection::access();
        try {
            $sql = "update users set name='$name',email='$email',address='$address',birth_date='$birthDate',phone='$phone' where UUID='$id'";
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
        $userList = [];
        $db = Connection::access();
        try {
            $sql = "select UUID,name,email,password,address,birth_date,phone,role from users order by '$field' desc limit $prev_offset, $next_offset ";
            $result = $db->query($sql);
            foreach ($result as $user) {
                $userList[] = new User(new UserId($user['UUID']), new UserName($user['name']), new UserEmail($user['email']), new UserPassword($user['password']),
                    new UserAddress($user['address']), new UserBirthDate($user['birth_date']),
                    new UserPhone($user['phone']), new UserRole($user['role']));
            }
            return $userList;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        finally {
            $db = null;
        }
    }
}