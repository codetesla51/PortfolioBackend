<?php
header("Access-Control-Allow-Origin: https://devuthman.vercel.app/");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define("LARAVEL_START", microtime(true));

if (
  file_exists($maintenance = __DIR__ . "/../storage/framework/maintenance.php")
) {
  require $maintenance;
}

// Register the Composer autoloader...
require __DIR__ . "/../vendor/autoload.php";

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__ . "/../bootstrap/app.php";

$app->handleRequest(Request::capture());
