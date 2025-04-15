<?php
include_once __DIR__ . "../../../config/config.php";
include_once __DIR__ . "../../../php/conexion.php";

$titulo = "Registrar Periodo - " . SIGLAS;
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
    <form method="post" id="form_periodo">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label" for="fecha_inicio">Fecha de Inicio</label>
                <input class="form-control form-control-lg rounded-0 border-2" type="date" name="fecha_inicio" id="fecha_inicio" placeholder="Fecha de Inicio...">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label" for="fecha_fin">Fecha de Fin</label>
                <input class="form-control form-control-lg rounded-0 border-2" type="date" name="fecha_fin" id="fecha_fin" placeholder="Fecha de Fin...">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label" for="activo">Activo</label>
                <select class="form-control form-control-lg rounded-0 border-2" name="activo" id="activo">
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
            </div>

            <div class="mb-3">
                <a href="<?= URL_RAIZ ?>view/periodos/" class="btn btn-lg btn-secondary rounded-0 text-uppercase">Volver</a>
                <button class="btn btn-lg btn-primary rounded-0 text-uppercase" type="submit">Crear Periodo</button>
            </div>

        </div>
    </form>

</div>

<?php ob_start(); ?>

<script src="<?= URL_RAIZ ?>js/periodos/app-create.js"></script>

<?php $scripts = ob_get_clean(); ?>

<?php include_once __DIR__ . "../../layout/footer.php"; ?>