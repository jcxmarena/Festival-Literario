<main class="escritores">
    <h2 class="escritores__heading">Escritores de esta edición</h2>
    <p class="escritores__descripcion">Conoce a todos nuestros autores</p>

    <div class="escritores__grid">
        <?php foreach($escritores as $escritor) { 
            $idEscritor = $escritor->id_escritor;
            // Toma el primer libro encontrado para ese escritor (Partiendo de la idea de que solo añadimos un libro por escritor)
            // Además es solo un extra para visualizar los libros dentro de la pestaña de escritores
            $primerLibro = ($idEscritor && !empty($librosPorEscritor[$idEscritor]))
                ? $librosPorEscritor[$idEscritor][0]
                : null;
        ?>
            <div class="escritor">
                <picture>
                    <source srcset="img/escritores/<?php echo $escritor->imagen; ?>.webp" type="image/webp">
                    <source srcset="img/escritores/<?php echo $escritor->imagen; ?>.png" type="image/png">
                    <img class="escritor__imagen" loading="lazy" width="200" height="300" src="img/escritores/<?php echo $escritor->imagen; ?>.png" alt="Fotografía del escritor">
                </picture>

                <div class="escritor__informacion">
                    <h4 class="escritor__nombre"><?php echo $escritor->nombre; ?></h4>

                    <p class="escritor__nacionalidad">
                        Nacionalidad: <?php echo $escritor->nacionalidad; ?>
                    </p>

                    <p class="escritor__biografia"><?php echo $escritor->biografia; ?></p>

                    <p class="escritor__libro">
                        <strong>Libros disponibles:</strong>
                        <?php echo $primerLibro ? htmlspecialchars($primerLibro->titulo) : 'No disponible'; ?>
                    </p>
                </div>
            </div>
        <?php } ?>
    </div>
</main>
