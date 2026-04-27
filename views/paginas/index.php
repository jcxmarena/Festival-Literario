<main>
    <h2 class="programa__heading">¡Nuestro festival hasta el momento!</h2>
    <section class="resumen">
        <div class="resumen__grid">
            <div class="resumen__bloque">
                <p class="resumen__texto resumen__texto--numero"><?php echo $escritores ?? 0; ?></p>
                <p class="resumen__texto">Escritores</p>
            </div>

            <div class="resumen__bloque">
                <p class="resumen__texto resumen__texto--numero"><?php echo $eventos ?? 0; ?></p>
                <p class="resumen__texto">Eventos</p>
            </div>

            <div class="resumen__bloque">
                <p class="resumen__texto resumen__texto--numero"><?php echo $localizaciones ?? 0; ?></p>
                <p class="resumen__texto">Localizaciones</p>
            </div>

            <div class="resumen__bloque">
                <p class="resumen__texto resumen__texto--numero"><?php echo $registros ?? 0; ?></p>
                <p class="resumen__texto">Asistentes</p>
            </div>
        </div>
    </section>

    <section>
        <h2 class="programa__heading">Nuestros patrocinadores</h2>
        <p class="programa__descripcion">Las editoriales que trabajan con nosotros</p>

        <div class="eventos">
            <div class="eventos__listado slider swiper">
                <div class="swiper-wrapper">
                    <?php foreach($editoriales as $editorial ) { ?>
                        <div class="evento  swiper-slide">
                            <div class="evento__informacion">
                                <h4 class="evento__titulo"><?php echo $editorial->nombre; ?></h4>
                                <h4 class="evento__titulo"><?php echo $editorial->pais; ?></h4>
                                <p class="evento__descripcion">Fundada en el año <?php echo $editorial->anio_fundacion; ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </section>

</main>

