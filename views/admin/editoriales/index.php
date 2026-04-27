<h2 class="dashborad__heading"><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/editoriales/crear">
        <i class="fa-solid fa-circle-plus"></i> Añadir editorial</a>
</div>

<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>

<?php if (!empty($_SESSION['alerta'])): ?>
    <script>
        alert("<?php echo addslashes($_SESSION['alerta']); ?>");
    </script>
    <?php unset($_SESSION['alerta']); ?>
<?php endif; ?>


<div class="dashboard__contenedor">
    <?php if(!empty($editoriales)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Nombre</th>
                    <th scope="col" class="table__th">País</th>
                    <th scope="col" class="table__th">Año de fundación</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach($editoriales as $editorial) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $editorial->nombre; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $editorial->pais; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $editorial->anio_fundacion; ?>
                        </td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/editoriales/editar?id=<?php echo $editorial->id_editorial; ?>">
                                <i class="fa-solid fa-pencil"></i>
                                Editar
                            </a>

                            <form method="POST" action="/admin/editoriales/eliminar" class="table__formulario">
                                <input type="hidden" name="id" value="<?php echo $editorial->id_editorial; ?>">
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
        <p class="text-center">No hay editoriales.</p>
    <?php } ?>