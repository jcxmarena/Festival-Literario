<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información del escritor</legend>

    <div class="formulario__campo">
        <label for="nombre" class="formulario__label">Nombre</label>
        <input
            type="text"
            class="formulario__input"
            id="nombre"
            name="nombre"
            placeholder="Nombre del escritor"
            value="<?php echo $escritor->nombre ?? ''; ?>"
        >
    </div>

    <div class="formulario__campo">
        <label for="nacionalidad" class="formulario__label">Nacionalidad</label>
        <input
            type="text"
            class="formulario__input"
            id="nacionalidad"
            name="nacionalidad"
            placeholder="Nacionalidad del escritor"
            value="<?php echo $escritor->nacionalidad ?? ''; ?>"
        >
    </div>

    <div class="formulario__campo">
        <label for="biografia" class="formulario__label">Biografia</label>
        <textarea
            class="formulario__input"
            id="biografia"
            name="biografia"
            placeholder="Breve biografia delescritor"
            rows="5">
            <?php echo $escritor->biografia ?? ''; ?></textarea>
    </div>

    <div class="formulario__campo">
        <label for="imagen" class="formulario__label">Imagen</label>
        <input
            type="file"
            class="formulario__input formulario__input--file"
            id="imagen"
            name="imagen"
        >
    </div>

    <?php if(isset($escritor->imagen_actual)) { ?>
        <p class="formulario__texto">Imagen actual:</p>
        <div class="formulario__imagen">
            <picture>
                <source srcset="<?php echo $_ENV['HOST'] . '/img/escritores/' . $escritor->imagen; ?>.webp" type="image/webp">
                <source srcset="<?php echo $_ENV['HOST'] . '/img/escritores/' . $escritor->imagen; ?>.png" type="image/png">
                <img src="<?php echo $_ENV['HOST'] . '/img/escritores/' . $escritor->imagen; ?>.png" alt="Imagen escritor">
            </picture>
        </div>

    <?php } ?>
</fieldset>