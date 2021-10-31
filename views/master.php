<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intcomex - Prueba Técnica Desarrollador - Ing. Darío Rumbo</title>

    <!--Bootstrap CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?=ROOT_DIR?>"><?=$home?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <?php foreach ($acciones as $accion => $link) { ?>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?=$link?>"><?=$accion?></a>
                </li>
            <?php } ?>
        </ul>
        </div>
    </div>
    </nav>
    
    <?php 
        if (IS_POST) {
            if ($exito) 
                echo "<div class=\"alert alert-success\" role=\"alert\">Acción exitosa</div>";
            elseif ($error = $controller->getError()) {
                $errData = $controller->getErrorData();
                $errores = $error.($errData ? ":<ul><li>".implode('</li><li>', $controller->getErrorData())."</li></ul>" : '');
                echo "<div class=\"alert alert-danger\" role=\"alert\">$errores</div>";
            }
        }
    ?>

    <div class="container py-3">
        <?= $module ?>
    </div>
</body>
</html>