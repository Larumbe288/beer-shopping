<?php

namespace BeerShopping\App\Controllers\MVCControllers;

use BeerShopping\App\Models\Users\Application\AdminAutenticator;
use BeerShopping\App\Models\Users\Domain\ValueObject\UserEmail;
use BeerShopping\App\Models\Users\Domain\ValueObject\UserPassword;
use BeerShopping\App\Models\Users\Infrastucture\Mailer;
use BeerShopping\App\Models\Users\Infrastucture\MySQLAutenticatorRepository;

class AdminController
{
    private $repository;

    public function validateAdmin()
    {
        $this->repository = new MySQLAutenticatorRepository();
        $autenticator = new AdminAutenticator($this->repository);
        $email = new UserEmail($_POST["email"]);
        $password = new UserPassword($_POST["password"]);
        if ($autenticator($email, $password) !== false) {
        header("Location: ../admin/dashboard");
    }

    public function rememberPassword(): void
    {
        $email = new UserEmail($_REQUEST["email"]);
        $mailer = new Mailer('alvarolarumbe97@gmail.com', $email->getValue());
        $mailer->sendEmail("You have forgotten your password<br>Click in this link for updating it:<br>http://localhost/beer-shopping/index.php/admin/updatePassword", "");
        header("Location: ../../admin/dashboard");
    }

    public function updatePassword()
    {

    }
}