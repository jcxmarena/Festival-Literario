<header class="header">
    <div class="header__contenedor">
        <nav class="header__navegacion">
            <?php if(is_auth()) { ?>
                <a href="<?php echo is_admin() ? '/admin/dashboard' : '/mis-entradas'; ?>" class="header__enlace">Administración</a>
                <form method="POST" action="/logout" class="header__form">
                    <input type="submit" value="Cerrar Sesión" class="header__submit">
                </form>
            <?php } else { ?>
                <a href="/registro" class="header__enlace">Registrarse</a>
                <a href="/login" class="header__enlace">Iniciar Sesión</a>
            <?php } ?>
        </nav>

        <div class="header__contenido">
            <a href="/">
                <h1 class="header__logo">Festival de Literatura</h1>
            </a>

            <p class="header__texto">Octubre - 2025</p>

            <a href="/registro" class="header__boton">Inscribirse</a>
        </div>
    </div>
</header>
<div class="barra">
    <div class="barra__contenido">
        <a href="/">
            <h2 class="barra__logo">Festival de Literatura</h2>
        </a>
        <nav class="navegacion">
            <a href="/festival" class="navegacion__enlace <?php echo pagina_actual('/festival') ? 'navegacion__enlace--actual' : ''; ?>">Festival</a>
            <a href="/programa" class="navegacion__enlace <?php echo pagina_actual('/programa') ? 'navegacion__enlace--actual' : ''; ?>">Programa</a>
            <a href="/localizaciones" class="navegacion__enlace <?php echo pagina_actual('/localizaciones') ? 'navegacion__enlace--actual' : ''; ?>">Localizaciones</a>
            <a href="/escritores" class="navegacion__enlace <?php echo pagina_actual('/escritores') ? 'navegacion__enlace--actual' : ''; ?>">Escritores</a>
            <a href="/entradas" class="navegacion__enlace <?php echo pagina_actual('/entradas') ? 'navegacion__enlace--actual' : ''; ?>">Entradas</a>
        </nav>
    </div>
</div>