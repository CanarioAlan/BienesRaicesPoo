<?php
require 'includes/app.php';
incluirTemplate('header');
?>
<main class="contenedor seccion">
    <h1>Anuncios</h1>
    <?php
    include 'includes/templates/anuncio.php'
    ?>
</main>
<?php incluirTemplate('footer') ?>