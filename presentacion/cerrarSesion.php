<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php');
    exit;
}

$token = $_POST['csrf'] ?? '';

if (
    !is_string($token) ||
    !isset($_SESSION['csrf']) ||
    !hash_equals($_SESSION['csrf'], $token)
) {
    http_response_code(403);
    exit('Solicitud inválida.');
}

// Borramos los datos de la sesión.
$_SESSION = [];

// Eliminamos la cookie de sesión.
if (ini_get('session.use_cookies')) {
    $parametros = session_get_cookie_params();

    setcookie(session_name(), '', [
        'expires' => time() - 3600,
        'path' => $parametros['path'],
        'domain' => $parametros['domain'],
        'secure' => $parametros['secure'],
        'httponly' => $parametros['httponly'],
        'samesite' => $parametros['samesite'] ?? 'Lax'
    ]);
}

session_destroy();

header('Location: ../index.php');
exit;