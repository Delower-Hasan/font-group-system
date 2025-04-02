<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use App\Config\Config;
$capsule = new Capsule();

$capsule->addConnection([
    'driver'    => 'mysql',         // Database driver
    'host'      => Config::DB_HOST,     // Database host
    'database'  => Config::DB_NAME,           // Database name
    'username'  => Config::DB_USER,          // Database username
    'password'  => Config::DB_PASS,              // Database password
    'charset'   => 'utf8',          // Character set
    'collation' => 'utf8_general_ci', // Collation
    'prefix'    => '',              // Table prefix
]);



$capsule->setAsGlobal();
$capsule->bootEloquent();
