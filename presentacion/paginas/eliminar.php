<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    echo '<p>Tenés que iniciar sesión para eliminar usuarios.</p>';
    return;
}

require_once __DIR__ . '/../../APP/negocio/UsuarioServicio.php';

if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}

$email = '';
$mensaje = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $token = $_POST['csrf'] ?? '';

    if (
        !is_string($token) ||
        !hash_equals($_SESSION['csrf'], $token)
    ) {
        $error = 'Formulario inválido. Recargá la página.';

    } else {
        try {
            $servicio = new UsuarioServicio();

            if ($servicio->eliminarUsuario($email)) {
                $mensaje = 'Usuario eliminado correctamente.';
                $email = '';
            } else {
                $error = 'No existe un usuario con ese email.';
            }

        } catch (InvalidArgumentException $e) {
            $error = $e->getMessage();

        } catch (PDOException $e) {
            error_log($e->getMessage());
            $error = 'No se pudo eliminar el usuario.';
        }
    }
}
?>

<section>
    <h2>Eliminar usuario</h2>

    <?php if ($mensaje !== ''): ?>
        <p role="status">
            <?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?>
        </p>
    <?php endif; ?>

    <?php if ($error !== ''): ?>
        <p role="alert">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
        </p>
    <?php endif; ?>

    <form
        method="POST"
        action="index.php?pagina=eliminar"
        onsubmit="return confirm('¿Querés eliminar este usuario?');"
    >
        <input type="hidden" name="csrf"
               value="<?= htmlspecialchars(
                   $_SESSION['csrf'],
                   ENT_QUOTES,
                   'UTF-8'
               ) ?>">

        <label for="email">Email del usuario</label>

        <input
            type="email"
            id="email"
            name="email"
            maxlength="150"
            required
            value="<?= htmlspecialchars(
                $email,
                ENT_QUOTES,
                'UTF-8'
            ) ?>"
        >

        <button class="boton" type="submit">
            Eliminar usuario
        </button>
    </form>
</section>