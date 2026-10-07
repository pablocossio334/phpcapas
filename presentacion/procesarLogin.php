<?php
session_start();

require_once __DIR__ . '/../APP/negocio/UsuarioServicio.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
$clave = $_POST['clave'] ?? '';

try {
    $servicio = new UsuarioServicio();
    $usuario = $servicio->iniciarSesion($email, $clave);

    if ($usuario === null) {
        $_SESSION['error_login'] = 'Email o contraseña incorrectos.';

        header('Location: ../index.php?pagina=login');
        exit;
    }

    session_regenerate_id(true);

    $_SESSION['usuario'] = $usuario->getEmail();
    $_SESSION['rol'] = $usuario->getRol();
    $_SESSION['csrf'] = bin2hex(random_bytes(32));

    header('Location: ../index.php');
    exit;

} catch (PDOException $error) {
    error_log($error->getMessage());

    $_SESSION['error_login'] = 'No se pudo iniciar sesión.';

    header('Location: ../index.php?pagina=login');
    exit;
}