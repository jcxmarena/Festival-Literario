<main class="auth">
    <h2 class="auth__heading"><?php echo htmlspecialchars($titulo ?? 'Iniciar sesión'); ?></h2>
    <p class="auth__texto">Inicia sesión para inscribirte a los eventos.</p>

    <?php if (!empty($_GET['registro'])): ?>
        <p class="alerta alerta__exito">Registro correcto. Ahora puedes iniciar sesión.</p>
    <?php endif; ?>

    <?php require_once __DIR__ . '/../templates/alertas.php'; ?>

    <form method="POST" action="/login" class="formulario" novalidate>
        <div class="formulario__campo">
            <label for="correo" class="formulario__label">Correo</label>
            <input
                type="email"
                class="formulario__input"
                placeholder="Correo electrónico"
                id="correo"
                name="correo"
                value="<?php echo htmlspecialchars($usuario->correo ?? ''); ?>"
            >
        </div>

        <div class="formulario__campo">
            <label for="password" class="formulario__label">Contraseña</label>
            <input
                type="password"
                class="formulario__input"
                placeholder="Contraseña"
                id="password"
                name="password"
            >
        </div>

        <input type="submit" class="formulario__submit" value="Iniciar Sesión">
    </form>

    <div class="acciones">
        <a href="/registro" class="acciones__enlace">¿No tienes una cuenta? Regístrate aquí</a>
    </div>
</main>
