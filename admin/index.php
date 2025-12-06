<?php
require '../includes/app.php';
estadoAutenticado();

use App\Propiedad;
//creamos un metodo para traer las propiedades
$propiedades = Propiedad::propAll();
//escribir la consulta
$query = "SELECT * FROM propiedades;";
$resultadoConsulta = mysqli_query($db, $query);
$resultado = $_GET['resultado'] ?? null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //asignamos el id a una variable solamente cuando se envie el metodo post
    $id = $_POST['id'];
    //validamos que sea un entero
    $id = filter_var($id, FILTER_VALIDATE_INT);
    if ($id) {
        $propiedad = Propiedad::propFiltrada($id);
        $propiedad->eliminar();
        //rliminamos la imagen de la propiedad
        $query = "SELECT imagen FROM propiedades WHERE Id = $id";
        //ejecutar la consulta
        $resultadoImagen = mysqli_query($db, $query);
        //obtener la imagen
        $propiedad = mysqli_fetch_assoc($resultadoImagen);
        //eliminar la imagen del servidor
        unlink('../imagenes/' . $propiedad['imagen']);
    }
}
//usamos un template para el header
incluirTemplate('header');
?>
<main class="contenedor seccion">
    <h1>Administrador</h1>
    <?php
    if (intval($resultado) === 1): ?>
        <p class="alerta exito">Creado Correctamente</p>
    <?php endif; ?>
    <?php if (intval($resultado) === 2): ?>
        <p class="alerta exito">Actualizado Correctamente</p>
    <?php endif; ?>
    <?php if (intval($resultado) === 3): ?>
        <p class="alerta exito">Eliminado Correctamente</p>
    <?php endif; ?>
    <a href="/admin/propiedades/crear.php" class="boton boton-verde">Crear nueva propiedad</a>
    <!-- mostramos la consulta  -->
    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- recordar que el foreach siempre itera la cantidad de elementos que encuentre en el arreglo -->
            <?php foreach ($propiedades as $propiedad): ?>
                <tr>
                    <td><?php echo $propiedad->Id ?></td>
                    <td><?php echo $propiedad->titulo ?></td>
                    <td><img src="/imagenes/<?php echo $propiedad->imagen ?>" alt="Imagen de la propiedad" class="imagen-tabla"></td>
                    <td><?php echo $propiedad->precio ?></td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $propiedad->Id ?>">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="admin/propiedades/actualizar.php?id=<?php echo $propiedad->Id ?>" class="boton-amarillo">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>
<?php
//cerramos la conexion
mysqli_close($db);
incluirTemplate('footer')
?>