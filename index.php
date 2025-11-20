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
</head>
<body>
    <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?>!</h1>
    <p>Tu rol es: <strong><?php echo htmlspecialchars($_SESSION['rol']); ?></strong></p>

    <!-- Contenido común para todos los usuarios -->
    <h2>Sección para todos los usuarios</h2>
    <p>Aquí va información general que todos pueden ver.</p>

    <!-- Contenido exclusivo para administradores -->
    <?php if ($_SESSION['rol'] === 'admin'): ?>
        <h2>Panel de Administración</h2>
        <p>Solo los administradores pueden ver esto.</p>
        <a href="src/view/usuarios_crear.php">Crear usuarios</a><br>
        <a href="src/view/usuarios_listar.php">Listar usuarios</a>
    <?php endif; ?>

    <div id = "logout-btn">
        <button onclick="location.href='public/logout.php'">Cerrar sesión</button>
    </div>

</body>
</html>