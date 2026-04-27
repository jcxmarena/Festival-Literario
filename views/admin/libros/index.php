<h2 class="dashborad__heading"><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton" href="/admin/libros/crear">
        <i class="fa-solid fa-circle-plus"></i> Añadir libro</a>
</div>

<?php if (session_status() !== PHP_SESSION_ACTIVE) session_start(); ?>

<?php if (!empty($_SESSION['alerta'])): ?>
    <script>
        alert("<?php echo addslashes($_SESSION['alerta']); ?>");
    </script>
    <?php unset($_SESSION['alerta']); ?>
<?php endif; ?>


<div class="dashboard__contenedor">
    <?php if(!empty($libros)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Título</th>
                    <th scope="col" class="table__th">Año de publicación</th>
                    <th scope="col" class="table__th">Escritor</th>
                    <th scope="col" class="table__th">Categoría</th>
                    <th scope="col" class="table__th">Editorial</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach($libros as $libro) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $libro->titulo; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $libro->anio_publicacion; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $libro->escritor->nombre; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $libro->categoria->nombre; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $libro->editorial->nombre; ?>
                        </td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/libros/editar?id=<?php echo $libro->id_libro; ?>">
                                <i class="fa-solid fa-pencil"></i>
                                Editar
                            </a>

                            <form method="POST" action="/admin/libros/eliminar" class="table__formulario">
                                <input type="hidden" name="id" value="<?php echo $libro->id_libro; ?>">
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
        <p class="text-center">No hay libros.</p>
    <?php } ?>