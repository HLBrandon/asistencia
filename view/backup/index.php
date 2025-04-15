<?php
include_once __DIR__ . "../../../config/config.php";
include_once __DIR__ . "../../../php/conexion.php";

$titulo = "Respaldar Base de Datos - " . SIGLAS;
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
            <a href="<?= URL_RAIZ ?>php/backup/backup.php" class="btn btn-primary fs-2 fw-bold text-uppercase rounded-3">
                Respaldar<i class="bi bi-database-fill-down ms-3"></i>
            </a>
        </div>
    </div>

    <!-- Actividad Reciente -->
    <div class="card mb-4">
        <div class="card-body p-0">
            <div class="container py-3">
                <h3>Apartado para respaldar Base de Datos</h3>
                <p>Sólo el Administrador del Sistema puede descargar la base de datos</p>
            </div>
        </div>
    </div>

</div>

<?php ob_start(); ?>

<script src="<?= URL_RAIZ ?>js/sistemas/app-index.js"></script>

<?php $scripts = ob_get_clean(); ?>

<?php include_once __DIR__ . "../../layout/footer.php"; ?>