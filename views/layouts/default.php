
<!DOCTYPE html>
<html lang="fr" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? e($title) : 'Mon site' ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body class="d-flex flex-column h-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <a href="<?= $router->url('home') ?>" class="navbar-brand">Home</a>
    </nav>

    <div class="container mt-4">
        <?= $content ?>
    </div>
    
    <footer class="bg-light py-4 footer mt-auto">
        <div class="container">
            <?php if(defined('DEBUG_TIME')){ ?>
            Page générée en <?= round(1000 * (microtime(true) - DEBUG_TIME)) ?> ms.
            <?php } ?>
        </div>
    </footer>
</body>
</html>