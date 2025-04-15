<?php
include_once __DIR__ . "../../../config/config.php";
include_once __DIR__ . "../../../php/conexion.php";

$titulo = "Registrar Salón - " . SIGLAS;
include_once __DIR__ . "../../layout/header.php";
?>

<!-- Contenido principal -->
<div class="col-md-9 col-lg-10 ms-sm-auto px-4 main-content">
    <!-- Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
        <div>
            <h1 class="h2"><?= $titulo ?></h1>
            <p class="text-muted">Panel de <?= $titulo ?></p>
        </div>
    </div>

    <!-- Formulario -->
    <form method="post" id="form_salon">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label" for="id">Clave</label>
                <input class="form-control form-control-lg rounded-0 border-2" type="text" name="id" id="id" placeholder="Clave...">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label" for="nombre_salon">Nombre del salón</label>
                <input class="form-control form-control-lg rounded-0 border-2" type="text" name="nombre_salon" id="nombre_salon" placeholder="Nombre del salón...">
            </div>

            <div class="mb-3">
                <a href="<?= URL_RAIZ ?>view/salones/" class="btn btn-lg btn-secondary rounded-0 text-uppercase">Volver</a>
                <button class="btn btn-lg btn-primary rounded-0 text-uppercase" type="submit">Crear Salón</button>
            </div>

        </div>
    </form>

</div>

<?php ob_start(); ?>

<script src="<?= URL_RAIZ ?>js/salones/app-create.js"></script>

<?php $scripts = ob_get_clean(); ?>

<?php include_once __DIR__ . "../../layout/footer.php"; ?>
