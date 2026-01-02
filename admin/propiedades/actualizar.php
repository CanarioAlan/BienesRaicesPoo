<?php
//traemos el require de las funciones y llamamos a la funcion de autenticacion

use App\Propiedad;
use App\Vendedor;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;

require '../../includes/app.php';
//asignamos el resultado de la funcion a una variable
estadoAutenticado();
//validamos si no esta autenticado

//validamos el id de la url
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: /admin');
}
//optenemos los datos de la propiedad
$propiedad = Propiedad::propFiltrada($id);
// consulta para optener los vendedores
$vendedores = Vendedor::All();
//
// Arreglo con mensajes de errores
$errores = Propiedad::getErrores();
// Ejecutar el codigo despues de que el usuario envia el formulario | _server es una variable superglobal que contiene informacion del servidor y del entorno de ejecucion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //asingnar los atributos
    $args = $_POST['propiedad'];
    // manera larga
    // $args['titulo'] = $_POST['titulo'] ?? null;
    // $args['precio'] = $_POST['precio'] ?? null;
    // $args['imagen'] = $_POST['imagen'] ?? null;
    // $args['descripcion'] = $_POST['descripcion'] ?? null;
    // $args['habitaciones'] = $_POST['habitaciones'] ?? null;
    // $args['wc'] = $_POST['wc'] ?? null;
    // $args['estacionamiento'] = $_POST['estacionamiento'] ?? null;
    // $args['creado'] = $_POST['creado'] ?? null;
    // $args['vendedores_id'] = $_POST['vendedores_id'] ?? null;
    $propiedad->sincronizar($args);
    // imagenes
    //genera nombre unico
    $errores = $propiedad->validar();
    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
    $imagen = null;
    //subida de archivo
    if ($_FILES['propiedad']['tmp_name']['imagen']) {
        //al renombrar y psarle el driver de gb (ya activado anteriormente en el ini.php) utilizamos ::class y se auto exporta en la linea 5 
        $manager = new Image(Driver::class);
        //leemos la imagen y hacemos del uso de cover que tomas dos paremetros, ancho y alto (para mas info visitar https://image.intervention.io/v3)
        $imagen = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600);
        //le pasamos el nombre de la imagen nada mas ya que la iamgen aun sigue en memoria y no en el servidor
        $propiedad->setImagen($nombreImagen);
    }
    if (empty($errores)) {
        if ($_FILES['propiedad']['tmp_name']['imagen']) {
            $imagen->save(CARPETA_IMAGENES . $nombreImagen);
        }
        $resultado = $propiedad->guardar();
    }
}
incluirTemplate('header');
?>
<main class="contenedor seccion">
    <h1>Actualizar</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>
    <?php foreach ($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error ?>
        </div>
    <?php endforeach; ?>
    <!-- el enctype permite leer al backend leer los archivos, no importa con que tecnologia este echo, siempre colocaro si vas a enviar archivos -->
    <form class="formulario" method="POST" enctype="multipart/form-data">
        <?php include '../../includes/templates/formulario_prop.php' ?>
        <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
    </form>
</main>

<?php incluirTemplate('footer') ?>