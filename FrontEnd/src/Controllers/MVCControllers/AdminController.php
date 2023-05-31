<?php

namespace BeerMVC\Shopping\Controllers\MVCControllers;

use BeerApi\Shopping\Connection\Doctrine;
use BeerApi\Shopping\Users\Application\AdminAutenticator;
use BeerApi\Shopping\Users\Domain\ValueObject\UserEmail;
use BeerApi\Shopping\Users\Domain\ValueObject\UserPassword;
use BeerApi\Shopping\Users\Infrastructure\Mailer;
use BeerApi\Shopping\Users\Infrastructure\MySQLAutenticatorRepository;
use Exception;

class AdminController
{
    private $repository;

    /**
     * @throws Exception
     */
    public function validateAdmin()
    {
        $this->repository = new MySQLAutenticatorRepository();
        $autenticator = new AdminAutenticator($this->repository);
        try {
            $email = new UserEmail($_POST["email"]);
            $password = new UserPassword($_POST["password"]);
        } catch (Exception $e) {
            $_SESSION["logError"] = "Introduced data are invalid, please try again";
            header("Location: ../admin/login");
        }
        $check = $autenticator($email, $password);
        if ($check !== false) {
            $_SESSION["login"] = $email->getValue();
            header("Location: ../admin/dashboard");
        } else {
            $_SESSION["logError"] = "Introduced data are invalid, please try again";
            header("Location: ../admin/login");
        }
    }


    public
    function rememberPassword(): void
    {
        $email = new UserEmail($_REQUEST["email"]);
        $mailer = new Mailer('alvarolarumbe97@gmail.com', $email->getValue());
        $mailer->sendEmail("You have forgotten your password<br>Click in this link for updating it:<br>http://localhost/beer-shopping/index.html/admin/updatePassword", "");
        header("Location: ../../admin/dashboard");
    }

    public
    function updatePassword()
    {

    }

    public
    function testDatabase()
    {
        $con = Doctrine::access();
        var_dump($con->getConnection());
    }


}