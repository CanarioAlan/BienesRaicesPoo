<?php
define('TEMPLATE_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
//cremaos nuetra propio super global para las imagenes
define('CARPETA_IMAGENES', __DIR__ . '/../imagenes/');

// creamos una función para incluir templates con parámetros opcionales 
function incluirTemplate(string $nombre, bool $inicio = false)
{
    //usamos template_url que definimos en app.php, lo que hace es traer la ruta absoluta
    include  TEMPLATE_URL . "/{$nombre}.php";
}
//creamos una funcion para validar si el usuario esta autenticado, esta funcion devuelve un booleano
function estadoAutenticado()
{
    session_start();
    if (!$_SESSION['login']) {
        header('Location: /');
    }
}
function debugear($var)
{
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    exit;
}
//muy importante escapar el html
function s($html): string
{
    $s = htmlspecialchars($html);
    return $s;
}
