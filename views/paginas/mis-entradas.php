<?php
// Funcion para que se vea mejor la fecha
function fecha_legible($f) {
    $ts = strtotime($f ?? '');
    return $ts ? date('d/m/Y H:i', $ts) : '';
}
?>

<main class="mis-entradas">
    <h2 class="mis-entradas__heading">Mis entradas</h2>
    <p class="mis-entradas__descripcion">Consulta tus inscripciones y anula si no puedes acudir</p>

    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

    <?php if (empty($registros)) : ?>
        <div class="mis-entradas__vacio">
            <p>Aún no tienes inscripciones. Apúntate desde <a href="/entradas">Entradas</a></p>
        </div>
    <?php else: ?>
        <div class="mis-entradas__lista">
            <?php foreach ($registros as $r): 
                // Por seguridad he convertido a int el id y utilizamos htmlspecialchars, pero en otros casos no lo he puesto y no ha dado error
                $id_registros = (int)$r['id_registros'];
                $titulo       = htmlspecialchars($r['titulo'] ?? '', ENT_QUOTES, 'UTF-8');
                $fecha        = fecha_legible($r['fecha'] ?? null);
                $categoria    = htmlspecialchars($r['categoria'] ?? '', ENT_QUOTES, 'UTF-8');
                $localizacion = htmlspecialchars($r['localizacion'] ?? '', ENT_QUOTES, 'UTF-8');
            ?>
                <article class="entrada">
                    <div class="entrada__info">
                        <h3 class="entrada__titulo"><?= $titulo ?></h3>
                        <p class="entrada__meta">
                            <span class="entrada__fecha"><i class="fa-regular fa-clock"></i> <?= $fecha ?></span>
                            <?php if ($categoria): ?>
                                <span class="entrada__categoria"><i class="fa-solid fa-tag"></i> <?= $categoria ?></span>
                            <?php endif; ?>
                            <?php if ($localizacion): ?>
                                <span class="entrada__localizacion"><i class="fa-solid fa-location-dot"></i> <?= $localizacion ?></span>
                            <?php endif; ?>
                        </p>
                    </div>
                    <form method="POST" class="entrada__acciones" onsubmit="return confirm('¿Anular esta entrada?');">
                        <input type="hidden" name="accion" value="eliminar">
                        <input type="hidden" name="id_registros" value="<?= $id_registros ?>">
                        <button type="submit" class="entrada__boton boton--peligro">
                            <i class="fa-regular fa-circle-xmark"></i> Anular
                        </button>
                    </form>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>
