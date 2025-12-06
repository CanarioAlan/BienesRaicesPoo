<?php
require 'includes/app.php';
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: /');
    exit;
}
$db = conectarDB();
//hacemos la consulta
$query = "SELECT * FROM propiedades WHERE id = {$id}";
//optenemos los resultados
$resultado = mysqli_query($db, $query);
//validamos si existe el registro y redirigimos si no existe
if (!$resultado->num_rows) {
    header('Location: /');
}
$propiedad = mysqli_fetch_assoc($resultado);
incluirTemplate('header');
?>
<main class="contenedor seccion contenido-centrado">
    <h1><?php echo $propiedad['titulo']; ?></h1>
    <img loading="lazy" src="imagenes/<?php echo $propiedad["imagen"] ?>" alt="Anuncio destacado">
    <div class="resumen-propiedd">
        <p class="precio">$<?php echo $propiedad["precio"]; ?></p>
    </div>
    <ul class="iconos-caracteristicas">
        <li>
            <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="Icono WC">
            <p><?php echo $propiedad["wc"]; ?></p>
        </li>
        <li>
            <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="Icono Estacionamiento">
            <p><?php echo $propiedad["estacionamiento"]; ?></p>
        </li>
        <li>
            <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="Icono Habitaciones">
            <p><?php echo $propiedad["habitaciones"]; ?></p>
        </li>
    </ul>
    <p><?php echo $propiedad["descripcion"]; ?></p>
</main>
<?php
mysqli_close($db);
incluirTemplate('footer') ?>