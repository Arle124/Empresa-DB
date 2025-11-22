<?php
session_start();
require_once "../../../config/conexion.php";
require_once "../controller/TrabajadorController.php";

if ($_SESSION['rol'] !== 'admin') {
    require_once "../../includes/acceso_denegado.php";
}

$db = (new Database())->connect();
$controller = new TrabajadorController($db);

// Validar existencia de ID
if (!isset($_GET['id'])) die("ID de trabajador no especificado.");
$id_trabajador = $_GET['id'];
$trabajador = $controller->obtenerTrabajadorPorId($id_trabajador);

if (!$trabajador) die("Trabajador no encontrado.");

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $cc = $_POST['cc'];
    $primer_nombre = $_POST['primer_nombre'];
    $segundo_nombre = $_POST['segundo_nombre'];
    $primer_apellido = $_POST['primer_apellido'];
    $segundo_apellido = $_POST['segundo_apellido'];
    $telefono = $_POST['telefono'];

    $res = $controller->actualizarTrabajador($id_trabajador, $cc, $primer_nombre, $segundo_nombre, $primer_apellido, $segundo_apellido, $telefono);

    if ($res['status'] === true) {
        header("Location: trabajadores_listar.php");
        exit();
    } else {
        $error = $res['message'];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Trabajador</title>
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>
<body>

<div class="container">

    <h1>Editar Trabajador - <?= htmlspecialchars($trabajador['primer_nombre'] . ' ' . $trabajador['primer_apellido']) ?></h1>

    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <button onclick="location.href='trabajadores_listar.php'" class="btn-back">Regresar</button>

    <form method="POST">
        <label>Cédula</label>
        <input type="text" name="cc" value="<?= htmlspecialchars($trabajador['cc']) ?>" required>

        <label>Primer Nombre</label>
        <input type="text" name="primer_nombre" value="<?= htmlspecialchars($trabajador['primer_nombre']) ?>" required>

        <label>Segundo Nombre</label>
        <input type="text" name="segundo_nombre" value="<?= htmlspecialchars($trabajador['segundo_nombre']) ?>">

        <label>Primer Apellido</label>
        <input type="text" name="primer_apellido" value="<?= htmlspecialchars($trabajador['primer_apellido']) ?>" required>

        <label>Segundo Apellido</label>
        <input type="text" name="segundo_apellido" value="<?= htmlspecialchars($trabajador['segundo_apellido']) ?>">

        <label>Teléfono</label>
        <input type="text" name="telefono" value="<?= htmlspecialchars($trabajador['telefono']) ?>" required>

        <button type="submit">Actualizar</button>
    </form>

</div>

</body>
</html>