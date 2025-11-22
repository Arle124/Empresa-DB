<?php
require_once "../../config/conexion.php";
require_once "../controller/VehiculoController.php";
session_start();

if ($_SESSION['rol'] !== 'admin') die("Acceso denegado.");

$db = (new Database())->connect();
$controller = new VehiculoController($db);

$vehiculos = $controller->listarVehiculos();
?>

<h1>Lista de Vehículos</h1>
<button onclick="location.href='../../index.php'">Regresar</button>
<table border="1">
    <tr>
        <th>Placa</th>
        <th>Descripción</th>
        <th>Tonelaje Máximo</th>
        <th>Fecha de Creación</th>
    </tr>
    <?php foreach ($vehiculos as $vehiculo): ?>
    <tr>
        <td><?= htmlspecialchars($vehiculo['placa']) ?></td>
        <td><?= htmlspecialchars($vehiculo['descripcion']) ?></td>
        <td><?= htmlspecialchars($vehiculo['tonelaje_maximo'] ?? '0.00') ?></td>
        <td><?= htmlspecialchars($vehiculo['fecha_creacion']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>