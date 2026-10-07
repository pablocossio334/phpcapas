<h1>Administración de usuarios</h1>

        <div class="estado-sesion">
            <?php if ($sesionIniciada): ?>
                <span>
                    Hola,
                    <?= htmlspecialchars(
                        $_SESSION['usuario'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </span>

                <form method="POST" action="presentacion/cerrarSesion.php">
                    <input type="hidden" name="csrf"
                           value="<?= htmlspecialchars(
                               $_SESSION['csrf'],
                               ENT_QUOTES,
                               'UTF-8'
                           ) ?>">

                    <button class="boton" type="submit">
                        Cerrar sesión
                    </button>
                </form>
            <?php else: ?>
                <a class="boton" href="login.php">
                    Iniciar sesión
                </a>
            <?php endif; ?>
        </div>