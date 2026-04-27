<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información del evento</legend>

    <div class="formulario__campo">
        <label for="titulo" class="formulario__label">Título</label>
        <input
            type="text"
            class="formulario__input"
            id="titulo"
            name="titulo"
            placeholder="Título del evento"
            value="<?php echo $evento->titulo ?? ''; ?>"
        >
    </div>

    <div class="formulario__campo">
        <label for="descripcion" class="formulario__label">Descripción</label>
        <textarea
            class="formulario__input"
            id="descripcion"
            name="descripcion"
            placeholder="Breve descripción del evento"
            rows="5">
            <?php echo $evento->descripcion ?? ''; ?></textarea>
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
                <option <?php echo ($evento->id_escritor === $escritor->id_escritor) ? 'selected' : '' ?> value="<?php echo $escritor->id_escritor; ?>"><?php echo $escritor->nombre; ?></option>
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
                <option <?php echo ($evento->id_categoria === $categoria->id_categoria) ? 'selected' : '' ?> value="<?php echo $categoria->id_categoria; ?>"><?php echo $categoria->nombre; ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="formulario__campo">
        <label for="localizacion" class="formulario__label">Localización</label>
        <select
            class="formulario__select"
            id="localizacion"
            name="id_localizacion"
        >
            <option value="">Selecciona una localización</option>
            <?php foreach($localizaciones as $localizacion) { ?>
                <option <?php echo ($evento->id_localizacion === $localizacion->id_localizacion) ? 'selected' : '' ?> value="<?php echo $localizacion->id_localizacion; ?>"><?php echo $localizacion->nombre; ?></option>
            <?php } ?>
        </select>
    </div>
    
    <div class="formulario__campo">
    <label for="fecha" class="formulario__label">Fecha y hora del evento</label>
    <input
        type="datetime-local"
        class="formulario__input"
        id="fecha"
        name="fecha"
        value="<?php 
            if (!empty($evento->fecha)) {
                // $evento->fecha puede venir como 'Y-m-d H:i:s' (BD) o ya 'Y-m-d H:i'
                $ts = strtotime(str_replace('T',' ', $evento->fecha));
                if ($ts !== false) {
                    echo date('Y-m-d\TH:i', $ts);
                }
            }
        ?>"
        required
        >
    <div>
</fieldset>