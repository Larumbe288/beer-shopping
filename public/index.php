<?php

use Ngcs\Slim\CustomSlimApp;

error_reporting(E_ALL ^ E_DEPRECATED ^ E_STRICT);
ini_set("display_errors", 0);

// return OK for every options call, this only needed when called from angular
if (isset($_SERVER['HTTP_ORIGIN']) && (strtolower($_SERVER['REQUEST_METHOD']) == "options")) {
    header("HTTP/1.1 200 OK");
    exit(0);
}
// load slim library
require __DIR__ . '/../vendor/autoload.php';

// Run app

/** @var CustomSlimApp $app */
$app = require __DIR__ . '/../BackEnd/src/Slim/slim_setup.php';
// Run app
$app->run();
exit;
