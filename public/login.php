<?php
session_start();
require_once "../config/conexion.php";

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']);
    $clave = trim($_POST['clave']);

    // Validación simple del usuario
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $usuario)) {
        $error = "Usuario inválido.";
    } else {
        $db = new Database();
        $conn = $db->connect();

        try {
            $stmt = $conn->prepare("CALL sp_usuarios_login(:usuario)");
            $stmt->bindParam(':usuario', $usuario);
            $stmt->execute();
            
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();

            if ($user) {
                if (password_verify($clave, $user['clave'])) {
                    if ($user['estado'] === 'activo') {

                        session_regenerate_id(true);

                        $_SESSION['id'] = $user['id'];
                        $_SESSION['usuario'] = $user['usuario'];
                        $_SESSION['nombre'] = $user['nombre'];
                        $_SESSION['rol'] = $user['rol'];

                        header("Location: ../index.php");
                        exit;
                    } else {
                        $error = "Tu usuario está bloqueado.";
                    }
                } else {
                    $error = "Contraseña incorrecta.";
                }
            } else {
                $error = "Usuario no encontrado.";
            }
        } catch (PDOException $e) {
            $error = "Error en la base de datos: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Iniciar sesión</h2>

    <?php if($error): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="password" name="clave" placeholder="Contraseña" required>
        <button type="submit">Ingresar</button>
    </form>

</body>
</html>