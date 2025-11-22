<?php
session_start();
require_once "../../../config/conexion.php";
require_once "../controller/VehiculoController.php";

if ($_SESSION['rol'] !== 'admin') {
    require_once "../../includes/acceso_denegado.php";
}

$db = (new Database())->connect();
$controller = new VehiculoController($db);

if (!isset($_GET['id'])) die("ID de vehículo no especificado.");
$id_vehiculo = $_GET['id'];
$vehiculo = $controller->obtenerVehiculoPorId($id_vehiculo);

if (!$vehiculo) die("Vehículo no encontrado.");

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nuevaPlaca = $_POST['placa'];
    $nuevaDescripcion = $_POST['descripcion'];
    $nuevoTonelaje = $_POST['tonelaje_maximo'];

    $res = $controller->actualizarVehiculo($vehiculo['id_vehiculo'], $nuevaPlaca, $nuevaDescripcion, $nuevoTonelaje);

    if ($res['status'] === true) {
        header("Location: vehiculos_listar.php");
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
    <title>Editar Vehículo</title>
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>
<body>

<div class="container">

    <h1>Editar Información - <?= htmlspecialchars($vehiculo['placa']) ?></h1>

    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <button onclick="location.href='vehiculos_listar.php'" class="btn-back">Regresar</button>

    <form method="POST">
        <label>Placa</label>
        <input type="text" name="placa" value="<?= htmlspecialchars($vehiculo['placa']) ?>" required>

        <label>Descripción</label>
        <input type="text" name="descripcion" value="<?= htmlspecialchars($vehiculo['descripcion']) ?>" required>

        <label>Tonelaje Máximo</label>
        <input type="number" step="0.01" name="tonelaje_maximo"value="<?= htmlspecialchars($vehiculo['tonelaje_maximo']) ?>" required>
        
        <button type="submit">Actualizar</button>
    </form>

</div>

</body>
</html>