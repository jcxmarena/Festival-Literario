<aside class="dashboard__sidebar">
    <nav class="dashboard__menu">
        <a href="/admin/dashboard" class="dashboard__enlace <?php echo pagina_actual('/admin/dashboard') ? 'dashboard__enlace--actual' : ''; ?>">
            <i class="fa-solid fa-house dashboard__icono"></i>
            <span class="dashboard__menu-texto">
                Inicio
            </span>    
        </a>

        <a href="/admin/registros" class="dashboard__enlace <?php echo pagina_actual('/admin/registros') ? 'dashboard__enlace--actual' : ''; ?>">
            <i class="fa-solid fa-users dashboard__icono"></i>
            <span class="dashboard__menu-texto">
                Registros
            </span>    
        </a>

        <a href="/admin/eventos" class="dashboard__enlace <?php echo pagina_actual('/admin/eventos') ? 'dashboard__enlace--actual' : ''; ?>">
            <i class="fa-solid fa-calendar dashboard__icono"></i>
            <span class="dashboard__menu-texto">
                Eventos
            </span>    
        </a>

        <a href="/admin/escritores" class="dashboard__enlace <?php echo pagina_actual('/admin/escritores') ? 'dashboard__enlace--actual' : ''; ?>">
            <i class="fa-solid fa-feather"></i>
            <span class="dashboard__menu-texto">
                Escritores
            </span>    
        </a>
        <a href="/admin/libros" class="dashboard__enlace <?php echo pagina_actual('/admin/libros') ? 'dashboard__enlace--actual' : ''; ?>">
            <i class="fa-solid fa-book"></i>
            <span class="dashboard__menu-texto">
                Libros
            </span>    
        </a>
        <a href="/admin/editoriales" class="dashboard__enlace <?php echo pagina_actual('/admin/editoriales') ? 'dashboard__enlace--actual' : ''; ?>">
            <i class="fa-solid fa-newspaper"></i>
            <span class="dashboard__menu-texto">
                Editoriales
            </span>    
        </a>
        <a href="/admin/localizaciones" class="dashboard__enlace <?php echo pagina_actual('/admin/localizaciones') ? 'dashboard__enlace--actual' : ''; ?>">
            <i class="fa-solid fa-location-dot"></i>
            <span class="dashboard__menu-texto">
                Localizaciones
            </span>    
        </a>
        <a href="/admin/categorias" class="dashboard__enlace <?php echo pagina_actual('/admin/categorias') ? 'dashboard__enlace--actual' : ''; ?>">
            <i class="fa-solid fa-layer-group"></i>
            <span class="dashboard__menu-texto">
                Categorías
            </span>    
        </a>
    </nav>
</aside>