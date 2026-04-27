<main class="auth">
    <h2 class="auth__heading"><?php echo htmlspecialchars($titulo ?? 'Crear cuenta'); ?></h2>
    <p class="auth__texto">Regístrate para inscribirte a los eventos.</p>

    <?php require_once __DIR__ . '/../templates/alertas.php'; ?>

    <form method="POST" action="/registro" class="formulario" novalidate>
        <div class="formulario__campo">
            <label for="nombre" class="formulario__label">Nombre</label>
            <input
                type="text"
                class="formulario__input"
                placeholder="Nombre"
                id="nombre"
                name="nombre"
                value="<?php echo htmlspecialchars($usuario->nombre ?? ''); ?>"
            >
        </div>

        <div class="formulario__campo">
            <label for="apellidos" class="formulario__label">Apellidos</label>
            <input
                type="text"
                class="formulario__input"
                placeholder="Apellidos"
                id="apellidos"
                name="apellidos"
                value="<?php echo htmlspecialchars($usuario->apellidos ?? ''); ?>"
            >
        </div>

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
                placeholder="Contraseña (mín. 6 caracteres)"
                id="password"
                name="password"
            >
        </div>

        <div class="formulario__campo">
            <label for="password2" class="formulario__label">Repetir contraseña</label>
            <input
                type="password"
                class="formulario__input"
                placeholder="Repetir contraseña"
                id="password2"
                name="password2"
            >
        </div>

        <input type="submit" class="formulario__submit" value="Crear Cuenta">
    </form>

    <div class="acciones">
        <a href="/login" class="acciones__enlace">¿Ya tienes una cuenta? Inicia sesión aquí</a>
    </div>
</main>
