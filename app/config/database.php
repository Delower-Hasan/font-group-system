<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule();

$capsule->addConnection([
    'driver'    => 'mysql',         // Database driver
    'host'      => 'localhost',     // Database host
    'database'  => 'oop',           // Database name
    'username'  => 'root',          // Database username
    'password'  => '',              // Database password
    'charset'   => 'utf8',          // Character set
    'collation' => 'utf8_general_ci', // Collation
    'prefix'    => '',              // Table prefix
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();
