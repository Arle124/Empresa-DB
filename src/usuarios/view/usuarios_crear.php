<?php
session_start();
require_once "../../../config/conexion.php";
require_once "../controller/UsuarioController.php";

$db = (new Database())->connect();
$controller = new UsuarioController($db);

if ($_SESSION['rol'] !== 'admin') die("Acceso denegado.");

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $res = $controller->crearUsuario($_POST['usuario'], $_POST['clave'], $_POST['rol'], $_POST['nombre']);

    if ($res['status'] === true) {
        header("Location: usuarios_listar.php");
        exit();
    } else {
        $error = $res['message'];   // <-- Mensaje que viene del controlador
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Usuario</title>
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>
<body>

    <div class="container">

        <h1>Crear Usuario</h1>

        <?php if (!empty($error)): ?>
            <div class="error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <button onclick="location.href='../../../index.php'" class="btn-back">Regresar</button>

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

    </div>

</body>
</html>