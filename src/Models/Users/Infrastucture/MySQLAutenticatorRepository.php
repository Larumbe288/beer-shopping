<?php

namespace BeerShopping\App\Models\Users\Infrastucture;

use BeerShopping\App\Models\Users\Domain\Repositories\AutenticatorRepository;
use BeerShopping\App\Models\Users\Domain\ValueObject\UserEmail;
use BeerShopping\App\Models\Users\Domain\ValueObject\UserPassword;
use BeerShopping\App\Models\Users\Domain\ValueObject\UserRole;

class MySQLAutenticatorRepository implements AutenticatorRepository
{

    public function adminLogin(UserEmail $email, UserPassword $password)
    {
        $db = Connection::access();
        try {
            $pass = sha1($password);
            $sql = "select email,password from users where email='$email', password='$pass' and role='admin'";
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