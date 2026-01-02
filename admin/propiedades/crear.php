<?php
require '../../includes/app.php';

use App\Propiedad;
use App\Vendedor;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;

estadoAutenticado();
$propiedad  = new Propiedad;
// consulta para optener los vendedores 
$vendedores = Vendedor::All();
$errores = Propiedad::getErrores();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //y instanciamos la clase de propiedad una vez que validemos que es metodo post
    //le pasamos post ya que es un arreglo y propiedad toma como argumento un arreglo
    $propiedad  = new Propiedad($_POST['propiedad']);
    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
    //validamos que si se detecta una imagen, se hace uso de intervation image
    if ($_FILES['propiedad']['tmp_name']['imagen']) {
        //al renombrar y psarle el driver de gb (ya activado anteriormente en el ini.php) utilizamos ::class y se auto exporta en la linea 5 
        $manager = new Image(Driver::class);
        //leemos la imagen y hacemos del uso de cover que tomas dos paremetros, ancho y alto (para mas info visitar https://image.intervention.io/v3)
        $imagen = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600);
        //le pasamos el nombre de la imagen nada mas ya que la iamgen aun sigue en memoria y no en el servidor
        $propiedad->setImagen($nombreImagen);
    }
    $errores = $propiedad->validar();
    if (empty($errores)) {
        // imagenes
        //hacemos uso de nuestra super global
        if (!is_dir(CARPETA_IMAGENES)) {
            //mkdir crea carpetas
            mkdir(CARPETA_IMAGENES);
        }
        //guardamos la imagen en el servidor pasando la carpeta y el nombre con el cual la vamos a guardar
        $imagen->save(CARPETA_IMAGENES . $nombreImagen);
        $resultado = $propiedad->guardar();
    };
}
incluirTemplate('header');
?>
<main class="contenedor seccion">
    <h1>Crear</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>
    <?php foreach ($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error ?>
        </div>
    <?php endforeach; ?>
    <form action="/admin/propiedades/crear.php" class="formulario" method="POST" enctype="multipart/form-data">
        <?php include '../../includes/templates/formulario_prop.php' ?>
        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
    </form>
</main>

<?php incluirTemplate('footer') ?>