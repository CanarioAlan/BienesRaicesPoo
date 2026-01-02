<?php
require '../../includes/app.php';

use App\Vendedor;

estadoAutenticado();
$vendedor  = new Vendedor();
$errores = Vendedor::getErrores();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vendedor = new Vendedor($_POST['vendedor']);
    $errores = $vendedor->validar();
    // debugear($vendedor);
    if (empty($errores)) {
        $vendedor->guardar();
    }
}
incluirTemplate('header');
?>
<main class="contenedor seccion">
    <h1>Registrar Vendedor</h1>
    <a href="/admin" class="boton boton-verde">Volver</a>
    <?php foreach ($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error ?>
        </div>
    <?php endforeach; ?>
    <form action="/admin/vendedores/crear.php" class="formulario" method="POST" enctype="multipart/form-data">
        <?php include '../../includes/templates/formulario_vendedor.php' ?>
        <input type="submit" value="Registrar Vendedor" class="boton boton-verde">
    </form>
</main>

<?php incluirTemplate('footer') ?>