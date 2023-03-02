<?php
$home = "/beer-shoppings/src/index.php/";
$ruta = str_replace($home, "", $_SERVER["REQUEST_URI"]);
$array_ruta = array_filter(explode("/", $ruta));
if (isset($array_ruta[0]) && $array_ruta[0] === "admin" && isset($array_ruta[1]) && $array_ruta[1] === "login") {
    require "Views/index.html";
}
