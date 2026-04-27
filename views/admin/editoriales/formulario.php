<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información de la editorial</legend>

    <div class="formulario__campo">
        <label for="nombre" class="formulario__label">Nombre</label>
        <input
            type="text"
            class="formulario__input"
            id="nombre"
            name="nombre"
            placeholder="Nombre de la categoría"
            value="<?php echo $editorial->nombre ?? ''; ?>"
        >
    </div>

    <div class="formulario__campo">
        <label for="pais" class="formulario__label">País</label>
        <input
            type="text"
            class="formulario__input"
            id="pais"
            name="pais"
            placeholder="País de origen"
            value="<?php echo $editorial->pais ?? ''; ?>"
        >
    </div>

    <div class="formulario__campo">
        <label for="anio_fundacion" class="formulario__label">Año de fundación</label>
        <input
            type="number"
            class="formulario__input"
            id="anio_fundacion"
            name="anio_fundacion"
            placeholder="Ejemplo: 1985"
            min="1000"
            max="<?php echo date('Y'); ?>"
            value="<?php echo $editorial->anio_fundacion ?? ''; ?>"
        >
    </div>
</fieldset>