<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php
      $pageTitle = isset($titulo) ? htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8') : '';
    ?>
    <title>Evento Literario — <?= $pageTitle ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700;900&family=Outfit:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/build/css/app.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"
          integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="dashboard">
    <?php 
        include_once __DIR__ . '/templates/admin-header.php';
    ?>

    <div class="dashboard__grid">
        <?php
            include_once __DIR__ . '/templates/admin-nav.php';
        ?>

        <main class="dashboard__contenido" role="main" aria-label="Contenido principal">
            <?php
                echo $contenido;
            ?>
        </main>
    </div>
    <script src="/build/js/main.min.js" defer></script>
</body>
</html>
