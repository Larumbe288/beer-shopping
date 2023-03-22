<?php
require "Connection.php";
require "../Domain/Repositories/AutenticatorRepository.php";
require "../Domain/ValueObject/UserEmail.php";
require "../Domain/ValueObject/UserPassword.php";
require "MySQLAutenticatorRepository.php";

use BeerApi\Shopping\Users\Domain\ValueObject\UserEmail;
use BeerApi\Shopping\Users\Domain\ValueObject\UserPassword;
use BeerApi\Shopping\Users\Infrastucture\Connection;
use BeerApi\Shopping\Users\Infrastucture\MySQLAutenticatorRepository;

$con = Connection::access();
$repo = new MySQLAutenticatorRepository();
var_dump($repo->adminLogin(new UserEmail("alvaro@larumbe.es"), new UserPassword("Alvaro1234")));