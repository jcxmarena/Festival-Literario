
<main class="localizaciones">
    <h2 class="localizaciones__heading">¿Dónde nos encontramos?</h2>
    <p class="localizaciones__descripcion">Espacios del festival y puntos de interés</p>

    <div class="localizaciones__grid">
        <?php foreach ($localizaciones as $loc): 
            // Obtenemos la id
            $idLoc = $loc->id_localizacion;

            // Sanitiza textos y obtenemos el resto de datos
            $nombre     = htmlspecialchars($loc->nombre ?? '', ENT_QUOTES, 'UTF-8');
            $direccion  = htmlspecialchars($loc->direccion ?? '', ENT_QUOTES, 'UTF-8');
            $coordsRaw  = trim((string)($loc->coordenadas ?? ''));

            // Separamos las coordenadas
            $lat = $lng = null;
            if ($coordsRaw !== '') {
                $partes = preg_split('/\s*,\s*/', $coordsRaw);
                if (count($partes) === 2) {
                    $lat = is_numeric($partes[0]) ? (float)$partes[0] : null;
                    $lng = is_numeric($partes[1]) ? (float)$partes[1] : null;
                }
            }

            // Se genera un ID único para el mapa y así evitamos problemas en el DOM con todos los que vamos a tener
            $mapId = 'mapa-' . ($idLoc ?? uniqid());
        ?>
            <article class="localizacion">
                <div class="localizacion__info">
                    <h3 class="localizacion__nombre"><?= $nombre ?></h3>
                    <p class="localizacion__direccion">
                        <i class="fa-solid fa-location-dot"></i>
                        <?= $direccion ?>
                    </p>
                </div>

                <?php if ($lat !== null && $lng !== null): ?>
                    <div
                        id="<?= $mapId ?>"
                        class="localizacion__mapa"
                        data-lat="<?= htmlspecialchars((string)$lat, ENT_QUOTES, 'UTF-8') ?>"
                        data-lng="<?= htmlspecialchars((string)$lng, ENT_QUOTES, 'UTF-8') ?>"
                        data-nombre="<?= $nombre ?>"
                        data-direccion="<?= $direccion ?>"
                        aria-label="Mapa de <?= $nombre ?>"
                        role="region"
                    ></div>
                <?php else: ?>
                    <p class="localizacion__sin-mapa">
                        <i class="fa-regular fa-circle-xmark"></i>
                        Coordenadas no disponibles o con formato inválido.
                    </p>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Selecciona todos los contenedores con data-lat y data-lng
    var mapas = document.querySelectorAll('.localizacion__mapa[data-lat][data-lng]');
    if (!mapas.length || typeof L === 'undefined') return;

    // Recorremos todo los mapas
    mapas.forEach(function (el) {
        // Obtenemos los datos del html
        var lat = parseFloat(el.dataset.lat);
        var lng = parseFloat(el.dataset.lng);
        var nombre = el.dataset.nombre || 'Ubicación';
        var direccion = el.dataset.direccion || '';

        // Creamos un mapa centrado en las coordenadas dadas
        var map = L.map(el.id).setView([lat, lng], 15);

        // Añadimos OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Añadimos el marcador y el resto de la información. Hay que tener en cuenta que en las 
        // localizaciones aportadas las coordenadas no se corresponden realmente con el lugar. Es decir, si es Ciudad Real sí sale Ciudad Real, pero
        // la calle no va a coincidir con lo que se pide porque usé unas coordenadas genéricas del lugar
        L.marker([lat, lng]).addTo(map)
            .bindPopup('<strong>' + nombre + '</strong><br>' + direccion);
    });
});
</script>
