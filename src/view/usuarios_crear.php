<?php
session_start();
require_once "../../config/conexion.php";
require_once "../controller/UsuarioController.php";

$db = (new Database())->connect();
$controller = new UsuarioController($db);

if ($_SESSION['rol'] !== 'admin') die("Acceso denegado.");

$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $res = $controller->crearUsuario($_POST['usuario'], $_POST['clave'], $_POST['rol'], $_POST['nombre']);
    if ($res) {
        header("Location: usuarios_listar.php");
        exit();
    } else {
        $error = "Error al crear usuario.";
    }
}
?>

<h1>Crear Usuario</h1>
<?php if($error) echo "<p style='color:red;'>$error</p>"; ?>
<form method="POST">
    <input type="text" name="usuario" placeholder="Usuario" required>
    <input type="password" name="clave" placeholder="Contraseña" required>
    <input type="text" name="nombre" placeholder="Nombre" required>
    <select name="rol">
        <option value="usuario">Usuario</option>
        <option value="admin">Administrador</option>
    </select>
    <button type="submit">Crear</button>
</form>