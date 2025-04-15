<?php
include_once __DIR__ . "../../../config/config.php";
include_once __DIR__ . "../../../php/conexion.php";

$titulo = "Salones - " . SIGLAS;
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
        <div class="action-buttons d-flex gap-2">
            <a href="<?= URL_RAIZ ?>view/salones/create.php" class="btn btn-primary rounded-0">
                <i class="bi bi-plus-lg"></i> Nuevo
            </a>
        </div>
    </div>

    <!-- Actividad Reciente -->
    <div class="card mb-4">
        <div class="card-body p-0">
            <div class="table-responsive small">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="text-bg-primary">#</th>
                            <th class="text-bg-primary">Nombre del salón</th>
                            <th class="text-bg-primary">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="body-tabla">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php ob_start(); ?>

<script src="<?= URL_RAIZ ?>js/salones/app-index.js"></script>

<?php $scripts = ob_get_clean(); ?>

<?php include_once __DIR__ . "../../layout/footer.php"; ?>