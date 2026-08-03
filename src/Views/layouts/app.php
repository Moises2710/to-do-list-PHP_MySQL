<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Coronado To do List - Application Workspace">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Dashboard - Coronado To do List'; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="bg-body-tertiary">
    <div id="appLayoutWrapper" class="d-flex min-vh-100 position-relative overflow-x-hidden">
        <?php require __DIR__ . '/sidebar.php'; ?>
        <div class="d-flex flex-column flex-grow-1 min-w-0">
            <?php 
                $isAppLayout = true; 
                require __DIR__ . '/header.php'; 
            ?>
            <main class="flex-grow-1 page-main-content">
                <?= $content; ?>
            </main>
            <?php require __DIR__ . '/footer.php'; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="/assets/js/sidebar.js"></script>
</body>
</html>
