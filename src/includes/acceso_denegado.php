<?php
// acceso_denegado.php
// Este archivo muestra una página bonita cuando el usuario no tiene permiso
// Debes incluirlo después de session_start() y si detectas que el rol no es admin

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso Denegado</title>
    <link rel="stylesheet" href="../../../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Acceso Denegado</h1>
        <p>No tienes permisos para acceder a esta sección.</p>
        <button onclick="location.href='../../../index.php'" class="btn-back">Volver al inicio</button>
    </div>
</body>
</html>
<?php
exit(); // Detiene la ejecución después de mostrar la página
?>