<?php
require '../includes/app.php';
estadoAutenticado();

use App\Propiedad;
use App\Vendedor;
//creamos un metodo para traer las propiedades
$propiedades = Propiedad::All();
$vendedores = Vendedor::All();
//mensaje condicional
$resultado = $_GET['resultado'] ?? null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //asignamos el id a una variable solamente cuando se envie el metodo post
    $id = $_POST['id'];
    //validamos que sea un entero
    $id = filter_var($id, FILTER_VALIDATE_INT);
    if ($id) {
        $tipo =  $_POST['tipo'];
        if (validarContenido($tipo)) {
            if ($_POST['tipo'] == 'vendedor') {
                $vendedor = Vendedor::propFiltrada($id);
                $vendedor->eliminar();
                debugear('eliminando vendedor');
            } else  if ($_POST['tipo'] == 'propiedad') {
                debugear('eliminando propiedad');
                $propiedad = Propiedad::propFiltrada($id);
                $propiedad->eliminar();
            }
        }

        //rliminamos la imagen de la propiedad
        // $query = "SELECT imagen FROM propiedades WHERE id = $id";
        //ejecutar la consulta
        // $resultadoImagen = mysqli_query($db, $query);
        //obtener la imagen
        // $propiedad = mysqli_fetch_assoc($resultadoImagen);
        //eliminar la imagen del servidor
        // unlink('../imagenes/' . $propiedad['imagen']);
    }
}
//usamos un template para el header
incluirTemplate('header');
?>
<main class="contenedor seccion">
    <h1>Administrador</h1>
    <?php
    //convertimos el resultado en entero ya que lo recibimos como string
    $mensaje = mostrarNotificacion(intval($resultado));
    if ($mensaje) : ?>
        <p class="alerta exito"><?php echo s($mensaje); ?></p>
    <?php endif; ?>
    <a href="/admin/propiedades/crear.php" class="boton boton-verde">Crear nueva propiedad</a>
    <a href="/admin/vendedores/crear.php" class="boton boton-amarillo-inblock">Crear nuevo Vendedor</a>
    <!-- mostramos la consulta  -->
    <h2>Propiedades</h2>
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
                    <td><?php echo $propiedad->id ?></td>
                    <td><?php echo $propiedad->titulo ?></td>
                    <td><img src="/imagenes/<?php echo $propiedad->imagen ?>" alt="Imagen de la propiedad" class="imagen-tabla"></td>
                    <td><?php echo $propiedad->precio ?></td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $propiedad->id ?>">
                            <input type="hidden" name="tipo" value="propiedad">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="admin/propiedades/actualizar.php?id=<?php echo $propiedad->id ?>" class="boton-amarillo">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <h2>Vendedores</h2>
    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Telefono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- recordar que el foreach siempre itera la cantidad de elementos que encuentre en el arreglo -->
            <?php foreach ($vendedores as $vendedor): ?>
                <tr>
                    <td><?php echo $vendedor->id ?></td>
                    <td><?php echo $vendedor->nombre . " " . $vendedor->apellido ?></td>
                    <td><?php echo $vendedor->telefono ?></td>
                    <td>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $vendedor->id ?>">
                            <input type="hidden" name="tipo" value="vendedor">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                        <a href="admin/vendedores/actualizar.php?id=<?php echo $vendedor->id ?>" class="boton-amarillo">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>
<?php
incluirTemplate('footer')
?>