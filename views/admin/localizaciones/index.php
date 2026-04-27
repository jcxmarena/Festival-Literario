<h2 class="dashborad__heading"><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/localizaciones/crear">
        <i class="fa-solid fa-circle-plus"></i> Añadir localización</a>
</div>

<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>

<?php if (!empty($_SESSION['alerta'])): ?>
    <script>
        alert("<?php echo addslashes($_SESSION['alerta']); ?>");
    </script>
    <?php unset($_SESSION['alerta']); ?>
<?php endif; ?>


<div class="dashboard__contenedor">
    <?php if(!empty($localizaciones)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Nombre</th>
                    <th scope="col" class="table__th">Dirección</th>
                    <th scope="col" class="table__th">Coordenadas</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach($localizaciones as $localizacion) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $localizacion->nombre; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $localizacion->direccion; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $localizacion->coordenadas; ?>
                        </td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/localizaciones/editar?id=<?php echo $localizacion->id_localizacion; ?>">
                                <i class="fa-solid fa-pencil"></i>
                                Editar
                            </a>

                            <form method="POST" action="/admin/localizaciones/eliminar" class="table__formulario">
                                <input type="hidden" name="id" value="<?php echo $localizacion->id_localizacion; ?>">
                                <button class="table__accion table__accion--eliminar" type="submit">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>

                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-center">No hay localizaciones.</p>
    <?php } ?>
</div>