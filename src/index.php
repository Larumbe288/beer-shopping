<?php
require __DIR__ . "/../vendor/autoload.php";

use BeerShopping\App\Controllers\MVCControllers\AdminController;

$adminController = new AdminController();
$home = "/beer-shoppings/src/index.php/";
$ruta = str_replace($home, "", $_SERVER["REQUEST_URI"]);
$array_ruta = array_filter(explode("/", $ruta));
if (isset($array_ruta[0]) && $array_ruta[0] === "admin" && isset($array_ruta[1]) && $array_ruta[1] === "login") {
    require "views/template/login.html";
} elseif (isset($array_ruta[0]) && $array_ruta[0] === "admin" && isset($array_ruta[1]) && $array_ruta[1] === "validate") {
    $adminController->validateAdmin();
} elseif (isset($array_ruta[0]) && $array_ruta[0] === "admin" && isset($array_ruta[1]) && $array_ruta[1] === "dashboard") {
    require "views/template/index.html";
} elseif (isset($array_ruta[0]) && $array_ruta[0] === "admin" && isset($array_ruta[1]) && $array_ruta[1] === "remember" && !isset($array_ruta[2])) {
    require "views/template/forgot-password.html";
} elseif (isset($array_ruta[0]) && $array_ruta[0] === "admin" && isset($array_ruta[1]) && $array_ruta[1] === "remember" && isset($array_ruta[2]) && $array_ruta[2] === "send") {
    $adminController->rememberPassword();
} elseif (isset($array_ruta[0]) && $array_ruta[0] === "admin" && isset($array_ruta[1]) && $array_ruta[1] === "update") {
    $adminController->updatePassword();
}