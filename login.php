<?php
require 'includes/app.php';
$db = conectarDB();
//autenticamos el usuario
$errores = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //validamos el email con la función filter_var y con el parametro FILTER_VALIDATE_EMAIL
    //volvemos a sanitizar el email con mysqli_real_escape_string para evitar inyecciones SQL
    $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    $password = mysqli_real_escape_string($db, $_POST['password']);
    if (!$email) {
        $errores[] = "El email es obligatorio o no es valido";
    }
    if (!$password) {
        $errores[] = "El password es obligatorio ";
    }
    //revisamos con empty si el array de errores esta vacio
    if (empty($errores)) {
        //comprbamos si el usuario existe
        $query = "SELECT * FROM usuarios WHERE email = '{$email}' ";
        $resultado = mysqli_query($db, $query);
        //validamos del resultado con num_rows si hay algun registro
        if ($resultado->num_rows) {
            //revisamos si el password es correcto
            $usuario = mysqli_fetch_assoc($resultado);
            //verificamos el password
            //hacemos uso del password_verify para comparar el password ingresado con el hasheado en la base de datos
            $auth = password_verify($password, $usuario['password']);
            if ($auth) {
                //el usuario esta autenticado
                //usamos la funcion session_start para iniciar la sesion
                session_start();
                //llenamos el arreglo superglobal de session
                $_SESSION['usuario'] = $usuario['email'];
                $_SESSION['login'] = true;
                header('Location: /admin');
            } else {
                $errores[] = "El password es incorrecto";
            }
        } else {
            $errores[] = "El usuario no existe";
        }
    }
}
// importamos las funciones y el header
incluirTemplate('header');
?>
<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar Sesión</h1>
    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>
    <form method="POST" class="formulario">
        <fieldset>
            <legend>Email y Contraseña</legend>

            <label for="email">Correo Electrónico</label>
            <input type="email" placeholder="Tu Correo Electrónico" name="email" id="email" required>

            <label for="password">Contraseña</label>
            <input type="password" placeholder="Tu Contraseña" id="password" name="password" required>

        </fieldset>
        <input type="submit" value="Iniciar Sesión" class="boton boton-verde">
    </form>
</main>
<?php
incluirTemplate('footer');
?>