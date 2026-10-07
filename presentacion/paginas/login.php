<section class="login">
    <h2>Iniciar sesión</h2>

    <?php if (isset($_SESSION['error_login'])): ?>
        <p class="error" role="alert">
            <?= htmlspecialchars(
                $_SESSION['error_login'],
                ENT_QUOTES,
                'UTF-8'
            ) ?>
        </p>

        <?php unset($_SESSION['error_login']); ?>
    <?php endif; ?>

    <form method="POST" action="presentacion/procesarLogin.php">
        <label for="email">Email</label>
        <input
            type="email"
            id="email"
            name="email"
            autocomplete="username"
            required
        >

        <label for="clave">Contraseña</label>
        <input
            type="password"
            id="clave"
            name="clave"
            autocomplete="current-password"
            required
        >

        <button type="submit">Ingresar</button>
    </form>
</section>