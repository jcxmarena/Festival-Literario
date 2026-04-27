
<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información de la localización</legend>

    <div class="formulario__campo">
        <label for="nombre" class="formulario__label">Nombre</label>
        <input
            type="text"
            class="formulario__input"
            id="nombre"
            name="nombre"
            placeholder="Nombre de la localización"
            value="<?php echo $localizacion->nombre ?? ''; ?>"
        >
    </div>
    <div class="formulario__campo">
        <label for="direccion" class="formulario__label">Dirección</label>
        <input
            type="text"
            class="formulario__input"
            id="direccion"
            name="direccion"
            placeholder="Dirección de la localización"
            value="<?php echo $localizacion->direccion ?? ''; ?>"
        >
    </div>
    <div class="formulario__campo">
        <label for="coordenadas" class="formulario__label">Coordenadas</label>
        <input
            type="text"
            class="formulario__input"
            id="coordenadas"
            name="coordenadas"
            placeholder="Ejemplo: 43.3614,-5.8593"
            value="<?php echo $localizacion->coordenadas ?? ''; ?>"
        >
        <small class="formulario__ayuda">
            Introduce las coordenadas en formato <strong>latitud,longitud</strong>
        </small>
    </div>
</fieldset>