<?php
session_start();
require_once "../../../config/conexion.php";
require_once "../controller/TrabajadorController.php";

$db = (new Database())->connect();
$controller = new TrabajadorController($db);

$trabajadores = $controller->listarTrabajadores();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Trabajadores</title>
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>
<body>
<div class="container">
    <h1>Lista de Trabajadores</h1>

    <button onclick="location.href='../../../index.php'" class="btn-back">Regresar</button>

    <table border="1">
        <tr>
            <th>Cédula</th>
            <th>Nombre Completo</th>
            <th>Teléfono</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($trabajadores as $t): ?>
        <tr>
            <td><?= htmlspecialchars($t['cc']) ?></td>
            <td><?= htmlspecialchars($t['primer_nombre'] . ' ' . $t['segundo_nombre'] . ' ' . $t['primer_apellido'] . ' ' . $t['segundo_apellido']) ?></td>
            <td><?= htmlspecialchars($t['telefono']) ?></td>
            <td><?= htmlspecialchars($t['estado']) ?></td>
            <td>
                <button onclick="location.href='trabajadores_editar.php?id=<?= $t['id_trabajador'] ?>'">Editar</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>