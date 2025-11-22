<?php
session_start();
require_once "../../../config/conexion.php";
require_once "../controller/TrabajadorController.php";

$db = (new Database())->connect();
$controller = new TrabajadorController($db);

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $res = $controller->crearTrabajador(
        $_POST['cc'],
        $_POST['primer_nombre'],
        $_POST['segundo_nombre'],
        $_POST['primer_apellido'],
        $_POST['segundo_apellido'],
        $_POST['telefono']
    );

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
    <title>Crear Trabajador</title>
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>
<body>
<div class="container">
    <h1>Crear Trabajador</h1>

    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <button onclick="location.href='../../../index.php'" class="btn-back">Regresar</button>

    <form method="POST">
        <input type="text" name="cc" placeholder="Cédula" required>
        <input type="text" name="primer_nombre" placeholder="Primer Nombre" required>
        <input type="text" name="segundo_nombre" placeholder="Segundo Nombre">
        <input type="text" name="primer_apellido" placeholder="Primer Apellido" required>
        <input type="text" name="segundo_apellido" placeholder="Segundo Apellido">
        <input type="text" name="telefono" placeholder="Teléfono" required>
        <button type="submit">Crear</button>
    </form>
</div>
</body>
</html>