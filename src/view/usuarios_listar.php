<?php
session_start();
require_once "../../config/conexion.php";
require_once "../controller/UsuarioController.php";

// Verificar sesión
if (!isset($_SESSION['rol'])) {
    header("Location: ../../index.php");
    exit();
}

// Solo admins pueden acceder
if ($_SESSION['rol'] !== 'admin') {
    die("Acceso denegado.");
}

// Conexión y controlador
$db = (new Database())->connect();
$controller = new UsuarioController($db);

// Manejo del cambio de estado ANTES del HTML
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['cambiarEstado'])) {
    $id = intval($_POST['id']);
    $estado = $_POST['estado'];

    if ($estado === "activo" || $estado === "bloqueado") {
        $controller->actualizarEstado($id, $estado);
    }

    header("Location: usuarios_listar.php");
    exit();
}

// Cargar listado de usuarios
$usuarios = $controller->listarUsuarios();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listar Usuarios</title>
</head>
<body>
    <h1>Listado de Usuarios</h1>

    <button onclick="location.href='../../index.php'">Regresar</button>

    <table border="1" style="margin-top: 15px;">
    <tr>
        <th>ID</th>
        <th>Usuario</th>
        <th>Nombre</th>
        <th>Rol</th>
        <th>Estado</th>
        <th>Acciones</th>
    </tr>

    <?php foreach ($usuarios as $u): ?>
    <tr>
        <td><?= htmlspecialchars($u['id']) ?></td>
        <td><?= htmlspecialchars($u['usuario']) ?></td>
        <td><?= htmlspecialchars($u['nombre']) ?></td>
        <td><?= htmlspecialchars($u['rol']) ?></td>
        <td><?= htmlspecialchars($u['estado']) ?></td>
        <td>
            <?php if ($u['rol'] !== 'admin'): ?>
                <form method="POST">
                    <input type="hidden" name="id" value="<?= $u['id'] ?>">
                    <select name="estado">
                        <option value="activo" <?= $u['estado'] === 'activo' ? 'selected' : '' ?>>Activo</option>
                        <option value="bloqueado" <?= $u['estado'] === 'bloqueado' ? 'selected' : '' ?>>Bloqueado</option>
                    </select>
                    <button type="submit" name="cambiarEstado">Actualizar</button>
                </form>
            <?php else: ?>
                <i>No modificable</i>
            <?php endif; ?>
        </td>

    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>