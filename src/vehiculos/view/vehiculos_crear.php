<?php
require_once "../../../config/conexion.php";
require_once "../controller/VehiculoController.php";
session_start();

// if ($_SESSION['rol'] !== 'admin') die("Acceso denegado.");

$error = "";

$db = (new Database())->connect();
$controller = new VehiculoController($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $res = $controller->crearVehiculo($_POST['placa'], $_POST['descripcion'], $_POST['tonelaje_maximo']);

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
    <title>Crear Vehículo</title>
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>
<body>

    <div class="container">

        <h1>Crear Vehículo</h1>

        <?php if (!empty($error)): ?>
            <div class="error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <button onclick="location.href='../../../index.php'" class="btn-back">Regresar</button>

        <form method="POST">

            <input type="text" name="placa" placeholder="Placa" required>

            <input type="text" name="descripcion" placeholder="Descripción" required>

            <input type="number" name="tonelaje_maximo" placeholder="Tonelaje Máximo" required>

            <button type="submit">Crear</button>
        </form>

    </div>

</body>
</html>