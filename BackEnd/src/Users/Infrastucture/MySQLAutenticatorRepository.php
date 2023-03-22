<?php

namespace BeerApi\Shopping\Users\Infrastucture;

use BeerApi\Shopping\Users\Domain\Repositories\AutenticatorRepository;
use BeerApi\Shopping\Users\Domain\ValueObject\UserEmail;
use BeerApi\Shopping\Users\Domain\ValueObject\UserPassword;

class MySQLAutenticatorRepository implements AutenticatorRepository
{

    public function adminLogin(UserEmail $email, UserPassword $password)
    {
        $emailValue = $email->getValue();
        $passwordValue = $password->getValue();
        $db = Connection::access();
        try {
            $pass = sha1($passwordValue);
            $sql = "select email,password from users where email='$emailValue' and password='$pass' and role='admin'";
            $users = $db->query($sql);
            return $users->fetch();
        } catch (\PDOException $e) {
            echo "DB Error: " . $e->getMessage();
        }
        finally {
            $db = null;
        }
    }

    public function userLogin()
    {
        // TODO: Implement userLogin() method.
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