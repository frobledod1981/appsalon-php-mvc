<?php

use Model\ActiveRecord;
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

require 'funciones.php';
require 'database.php';
// require __DIR__ . '/../vendor/autoload.php';

// Conectarnos a la base de datos
// use Model\ActiveRecord;
ActiveRecord::setDB($db);