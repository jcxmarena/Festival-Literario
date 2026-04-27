<main class="programa">
    <h2 class="programa__heading">Programación del festival</h2>
    <p class="programa__descripcion">Conferencias, firmas y talleres de nuestros escritores</p>

    <div class="eventos">
        <div class="eventos__listado slider swiper">
            <div class="swiper-wrapper">
                <?php foreach($eventos as $evento ) { ?>
                    <div class="evento  swiper-slide">
                        <p class="evento__fecha">
                            <?php 
                                setlocale(LC_TIME, 'spanish');
                                echo $evento->localizacion->nombre . " — " . strftime('%e de %B de %Y a las %H:%M', strtotime($evento->fecha));
                            ?>
                        </p>
                        <div class="evento__informacion">
                            <h4 class="evento__titulo"><?php echo $evento->titulo . " —— " . $evento->categoria->nombre; ?></h4>
                            <h4 class="evento__titulo"><?php echo $evento->categoria->nombre; ?></h4>
                            <p class="evento__descripcion"><?php echo $evento->descripcion; ?></p>
                            <div class="evento__escritor-info">
                                <picture>
                                    <source srcset="img/escritores/<?php echo $evento->escritor->imagen; ?>.webp" type="image/webp">
                                    <source srcset="img/escritores/<?php echo $evento->escritor->imagen; ?>.png" type="image/png">
                                    <img class="evento__imagen-escritor" loading="lazy" width="200" height="300" src="img/escritores/<?php echo $evento->escritor->imagen; ?>.png" alt="Fotografía del escritor">
                                </picture>
                                <p class="evento__escritor-nombre">
                                    <?php echo $evento->escritor->nombre; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</main>