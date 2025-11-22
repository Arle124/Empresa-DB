<?php
require_once "../../../config/conexion.php";
require_once "../controller/VehiculoController.php";
session_start();

// if ($_SESSION['rol'] !== 'admin') die("Acceso denegado.");

$db = (new Database())->connect();
$controller = new VehiculoController($db);

$vehiculos = $controller->listarVehiculos();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Vehículos</title>
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>
<body>

    <div class="container">

        <h1>Lista de Vehículos</h1>

        <button onclick="location.href='../../../index.php'" class="btn-back">Regresar</button>

        <table class="table">
            <thead>
                <tr>
                    <th>Placa</th>
                    <th>Descripción</th>
                    <th>Tonelaje Máximo</th>
                    <th>Fecha de Creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vehiculos as $vehiculo): ?>
                <tr>
                    <td><?= htmlspecialchars($vehiculo['placa']) ?></td>
                    <td><?= htmlspecialchars($vehiculo['descripcion']) ?></td>
                    <td><?= htmlspecialchars($vehiculo['tonelaje_maximo'] ?? '0.00') ?></td>
                    <td><?= htmlspecialchars($vehiculo['fecha_creacion']) ?></td>
                    <td>
                        <button onclick="location.href='vehiculos_editar.php?id=<?= $vehiculo['id_vehiculo'] ?>'">Editar</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

</body>
</html>