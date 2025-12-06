<?php
//importar la conexion
require 'includes/config/database.php';
$db = conectarDB();
//crear im email y password
$email = "correo@correo.com";
$passsword = "123456";
// usamos password_hash para encriptar el password
// usar password_default para que use el mejor algoritmo disponible y se actualice con el tiempo automaticamente
$passswordHash = password_hash($passsword, PASSWORD_DEFAULT);
//query para hacer el usuario
$query = "INSERT INTO usuarios (email, password) VALUES ('$email', '$passswordHash')";

//agregarlo a la base de datos
mysqli_query($db, $query);
// cuando creamos la tabla de usuarios en el campo de password siempre poner char(60) ya que el password encriptado ocupa 60 caracteres