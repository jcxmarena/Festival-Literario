<?php 
// Para ver mejor la fecha
function fecha_legible($fechaSql) {
    $ts = strtotime($fechaSql ?? '');
    return $ts ? date('d/m/Y H:i', $ts) : '';
}
?>

<main class="entradas">
    <h2 class="entradas__heading">Registro de eventos</h2>
    <p class="entradas__descripcion">Elige un evento y confirma tu inscripción</p>

    <div class="dashboard__formulario">
        <?php 
        include_once __DIR__ . '/../templates/alertas.php';
        ?>

        <form method="POST" class="formulario">
            <fieldset class="formulario__fieldset">
                <legend class="formulario__legend">Escoge un evento</legend>
                <div class="formulario__campo">
                    <label for="id_evento" class="formulario__label">Evento</label>
                    <select name="id_evento" id="id_evento" required>
                        <option value="">— Selecciona un evento —</option>
                        <?php foreach ($eventos as $ev): 
                            $id     = $ev->id_evento ?? $ev->id ?? null;
                            $titulo = htmlspecialchars($ev->titulo ?? '', ENT_QUOTES, 'UTF-8');
                            $fecha  = fecha_legible($ev->fecha ?? null);
                        ?>
                            <option value="<?= htmlspecialchars((string)$id) ?>">
                                <?= $titulo ?> (<?= $fecha ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </fieldset>

            <input class="formulario__submit formulario__submit--crear" type="submit" value="Registrarme">
        </form>
    </div>
</main>
