<h2 class="dashborad__heading"><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/escritores/crear">
        <i class="fa-solid fa-circle-plus"></i> Añadir escritor</a>
</div>

<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>

<?php if (!empty($_SESSION['alerta'])): ?>
    <script>
        alert("<?php echo addslashes($_SESSION['alerta']); ?>");
    </script>
    <?php unset($_SESSION['alerta']); ?>
<?php endif; ?>


<div class="dashboard__contenedor">
    <?php if(!empty($escritores)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Nombre</th>
                    <th scope="col" class="table__th">Nacionalidad</th>
                    <th scope="col" class="table__th">Biografía</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach($escritores as $escritor) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $escritor->nombre; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $escritor->nacionalidad; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $escritor->biografia; ?>
                        </td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/escritores/editar?id=<?php echo $escritor->id_escritor; ?>">
                                <i class="fa-solid fa-pencil"></i>
                                Editar
                            </a>

                            <form method="POST" action="/admin/escritores/eliminar" class="table__formulario">
                                <input type="hidden" name="id" value="<?php echo $escritor->id_escritor; ?>">
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
        <p class="text-center">No hay escritores.</p>
    <?php } ?>
</div>