<?php
require_once "../../config/conexion.php";
require_once "../controller/VehiculoController.php";
session_start();

if ($_SESSION['rol'] !== 'admin') die("Acceso denegado.");

$error = "";

$db = (new Database())->connect();
$controller = new VehiculoController($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $res = $controller->crearVehiculo($_POST['placa'], $_POST['descripcion'], $_POST['tonelaje']);

    if ($res['status'] === true) {
        header("Location: vehiculos_listar.php");
        exit();
    } else {
        $error = $res['message'];
    }

}
?>

<h1>Crear Vehículo</h1>
<?php if (!empty($error)): ?>
<div style="color:red; font-weight:bold; margin-bottom:10px;">
    <?= htmlspecialchars($error) ?>
</div>
<?php endif; ?>
<button onclick="location.href='../../index.php'">Regresar</button>
<form method="POST">
    <input type="text" name="placa" placeholder="Placa" required>
    <input type="text" name="descripcion" placeholder="Descripción" required>
    <input type="number" name="tonelaje_maximo" placeholder="Tonelaje Máximo" required>

    <button type="submit">Crear</button>
</form>