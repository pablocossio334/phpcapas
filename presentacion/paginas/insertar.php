<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    echo '<p>Tenés que iniciar sesión para agregar usuarios.</p>';
    return;
}

require_once __DIR__ . '/../../APP/negocio/UsuarioServicio.php';

if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}

$mensaje = '';
$error = '';
$email = '';
$rol = 'alumno';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $clave = $_POST['clave'] ?? '';
    $rol = $_POST['rol'] ?? '';
    $token = $_POST['csrf'] ?? '';

    if (
        !is_string($token) ||
        !hash_equals($_SESSION['csrf'], $token)
    ) {
        $error = 'Formulario inválido. Recargá la página.';

    } else {
        try {
            $servicio = new UsuarioServicio();

            $guardado = $servicio->agregarUsuario(
                $email,
                $clave,
                $rol
            );

            if ($guardado) {
                $mensaje = 'Usuario agregado correctamente.';
                $email = '';
                $rol = 'alumno';
            } else {
                $error = 'No se pudo agregar el usuario.';
            }

        } catch (InvalidArgumentException $e) {
            $error = $e->getMessage();

        } catch (PDOException $e) {
            error_log($e->getMessage());

            $error = ($e->errorInfo[1] ?? null) === 1062
                ? 'Ya existe un usuario con ese email.'
                : 'No se pudo agregar el usuario.';
        }
    }
}
?>

<section>
    <h2>Agregar usuario</h2>

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

    <form method="POST" action="index.php?pagina=insertar">
        <input type="hidden" name="csrf"
               value="<?= htmlspecialchars(
                   $_SESSION['csrf'],
                   ENT_QUOTES,
                   'UTF-8'
               ) ?>">

        <div>
            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                maxlength="150"
                autocomplete="username"
                required
                value="<?= htmlspecialchars(
                    $email,
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>"
            >
        </div>

        <div>
            <label for="clave">Contraseña</label>
            <input
                type="password"
                id="clave"
                name="clave"
                autocomplete="new-password"
                required
            >
        </div>

        <div>
            <label for="rol">Rol</label>
            <select id="rol" name="rol" required>
                <option value="alumno"
                    <?= $rol === 'alumno' ? 'selected' : '' ?>>
                    Alumno
                </option>

                <option value="docente"
                    <?= $rol === 'docente' ? 'selected' : '' ?>>
                    Docente
                </option>
            </select>
        </div>

        <button class="boton" type="submit">
            Agregar usuario
        </button>
    </form>
</section>