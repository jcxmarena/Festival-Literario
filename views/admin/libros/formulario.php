<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información del libro</legend>

    <div class="formulario__campo">
        <label for="titulo" class="formulario__label">Título</label>
        <input
            type="text"
            class="formulario__input"
            id="titulo"
            name="titulo"
            placeholder="Título del libro"
            value="<?php echo $libro->titulo ?? ''; ?>"
        >
    </div>

    <div class="formulario__campo">
        <label for="anio_publicacion" class="formulario__label">Año de publicación</label>
        <input
            type="number"
            class="formulario__input"
            id="anio_publicacion"
            name="anio_publicacion"
            placeholder="Ejemplo: 1985"
            min="1000"
            max="<?php echo date('Y'); ?>"
            value="<?php echo $libro->anio_publicacion ?? ''; ?>"
        >
    </div>

    <div class="formulario__campo">
        <label for="escritor" class="formulario__label">Escritor</label>
        <select
            class="formulario__select"
            id="escritor"
            name="id_escritor"
        >
            <option value="">Selecciona un escritor</option>
            <?php foreach($escritores as $escritor) { ?>
                <option <?php echo ($libro->id_escritor === $escritor->id_escritor) ? 'selected' : '' ?> value="<?php echo $escritor->id_escritor; ?>"><?php echo $escritor->nombre; ?></option>
            <?php } ?>
        </select>
    </div> 

    <div class="formulario__campo">
        <label for="categoria" class="formulario__label">Categoría</label>
        <select
            class="formulario__select"
            id="categoria"
            name="id_categoria"
        >
            <option value="">Selecciona una categoría</option>
            <?php foreach($categorias as $categoria) { ?>
                <option <?php echo ($libro->id_categoria === $categoria->id_categoria) ? 'selected' : '' ?> value="<?php echo $categoria->id_categoria; ?>"><?php echo $categoria->nombre; ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="formulario__campo">
        <label for="editorial" class="formulario__label">Editorial</label>
        <select
            class="formulario__select"
            id="editorial"
            name="id_editorial"
        >
            <option value="">Selecciona una editorial</option>
            <?php foreach($editoriales as $editorial) { ?>
                <option <?php echo ($libro->id_editorial === $editorial->id_editorial) ? 'selected' : '' ?> value="<?php echo $editorial->id_editorial; ?>"><?php echo $editorial->nombre; ?></option>
            <?php } ?>
        </select>
    </div> 
</fieldset>