<?php
session_start();

// Verificar si hay sesión activa
if (!isset($_SESSION['usuario'])) {
    header("Location: public/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?>!</h1>
    <p>Tu rol es: <strong><?php echo htmlspecialchars($_SESSION['rol']); ?></strong></p>

    <!-- Contenido común para todos los usuarios -->

    <?php if ($_SESSION['rol'] === 'usuario'): ?>   

        <h2>Sección para todos los usuarios</h2>
        <p>Aquí va información general que todos pueden ver.</p>

        <button onclick="location.href='src/vehiculos/view/vehiculos_crear.php'">Registrar vehículos</button><br>
        <button onclick="location.href='src/vehiculos/view/vehiculos_listar.php'">Listar vehículos</button><br>

    <?php endif; ?>

    <!-- Contenido exclusivo para administradores -->
    <?php if ($_SESSION['rol'] === 'admin'): ?>
        <h2>Panel de Administración</h2>
        <p>Solo los administradores pueden ver esto.</p>

        <button onclick="location.href='src/usuarios/view/usuarios_crear.php'">Crear usuarios</button><br>
        <button onclick="location.href='src/usuarios/view/usuarios_listar.php'">Listar usuarios</button><br>
        <button onclick="location.href='src/vehiculos/view/vehiculos_crear.php'">Registrar vehículos</button><br>
        <button onclick="location.href='src/vehiculos/view/vehiculos_listar.php'">Listar vehículos</button><br>
        <button onclick="location.href='src/trabajadores/view/trabajadores_crear.php'">Registrar trabajadores</button><br>
        <button onclick="location.href='src/trabajadores/view/trabajadores_listar.php'">Listar trabajadores</button><br>
        
    <?php endif; ?>

    <div id = "logout-btn">
        <button onclick="location.href='public/logout.php'">Cerrar sesión</button>
    </div>

</body>
</html>