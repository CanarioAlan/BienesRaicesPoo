<?php
require '../../includes/app.php';

use App\Vendedor;

estadoAutenticado();
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: /admin');
}
$vendedor = Vendedor::propFiltrada($id);
$errores = Vendedor::getErrores();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //asignar los valores
    $args = $_POST['vendedor'];
    $vendedor->sincronizar($args);
    //validacion
    $errores = $vendedor->validar();
    if (empty($errores)) {
        $vendedor->guardar();
        header('Location: /admin?resultado=2');
    }
}
incluirTemplate('header');
?>
<main class="contenedor seccion">
    <h1>Actualizar Vendedor</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>
    <?php foreach ($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error ?>
        </div>
    <?php endforeach; ?>
    <form class="formulario" method="POST" enctype="multipart/form-data">
        <?php include '../../includes/templates/formulario_vendedor.php' ?>
        <input type="submit" value="Guardar cambios" class="boton boton-verde">
    </form>
</main>

<?php incluirTemplate('footer') ?>