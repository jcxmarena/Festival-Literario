<h2 class="dashborad__heading"><?php echo $titulo; ?></h2>

<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>

<?php if (!empty($_SESSION['alerta'])): ?>
    <script>
        alert("<?php echo addslashes($_SESSION['alerta']); ?>");
    </script>
    <?php unset($_SESSION['alerta']); ?>
<?php endif; ?>


<div class="dashboard__contenedor">
    <?php if(!empty($registros)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Nombre del asistente</th>
                    <th scope="col" class="table__th">Título del evento</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach($registros as $registro) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $registro->usuario->nombre; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $registro->evento->titulo; ?>
                        </td>
                        <td class="table__td--acciones">
                            <form method="POST" action="/admin/registros/eliminar" class="table__formulario">
                                <input type="hidden" name="id" value="<?php echo $registro->id_registros; ?>">
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
        <p class="text-center">No hay registros.</p>
    <?php } ?>