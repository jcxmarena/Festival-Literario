<?php if (!empty($alertas)) : ?>
    <div class="alertas">
        <?php foreach ($alertas as $tipo => $mensajes) : ?>
            <?php foreach ($mensajes as $mensaje) : ?>
                <div class="alerta alerta__<?= htmlspecialchars($tipo, ENT_QUOTES, 'UTF-8') ?>">
                    <?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
