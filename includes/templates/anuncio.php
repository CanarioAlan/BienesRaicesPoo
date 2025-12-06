<?php
//quitamos la importacion a la base de dats ya que en app ya esta echo
$db = conectarDB();
//hacemos la consulta
$query = "SELECT * FROM propiedades LIMIT {$limite}";
//optenemos los resultados
$resultado = mysqli_query($db, $query);
?>
<div class="contenedor-anuncio">
    <!-- iteramos en el resultado -->
    <?php while ($propiedad = mysqli_fetch_assoc($resultado)): ?>
        <div class="anuncio">
            <img loading="lazy" src="imagenes/<?php echo $propiedad["imagen"] ?>" alt="Anuncio 1">
            <div class="contenido-anuncio">
                <h3><?php echo $propiedad["titulo"] ?></h3>
                <p><?php echo $propiedad["descripcion"] ?></p>
                <p class="precio">$ <?php echo $propiedad["precio"] ?></p>
                <ul class="iconos-caracteristicas">
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="Icono WC">
                        <p><?php echo $propiedad["wc"] ?></p>
                    </li>
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg"
                            alt="Icono Estacionamiento">
                        <p><?php echo $propiedad["estacionamiento"] ?></p>
                    </li>
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg"
                            alt="Icono Habitaciones">
                        <p><?php echo $propiedad["habitaciones"] ?></p>
                    </li>
                </ul>
                <a href="anuncio.php?id=<?php echo $propiedad["Id"] ?>" class="boton boton-amarillo">Ver propiedad</a>
            </div>
        </div> <!--.anuncio-->
    <?php endwhile; ?>
</div> <!--.contenedor-anuncio-->
<?php mysqli_close($db) ?>