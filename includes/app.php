<?php
//este archivo pasa a ser el principal, el orquestador
//llamamos a todos los archivos necesarios
require 'funciones.php';
require 'config/database.php';
require __DIR__ . '/../vendor/autoload.php';
$db = conectarDB();

use App\ActiveRecord;

ActiveRecord::setDB($db);
