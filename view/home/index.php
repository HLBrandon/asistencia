<?php
include_once __DIR__ . "../../../config/config.php";
include_once __DIR__ . "../../../php/conexion.php";

$titulo = "Home - " . SIGLAS;
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

    <div class="bg-white p-4 rounded-3 mb-3">
        <h3>Bienvenido <?= $_SESSION['usuario']['nombre'] ?> <?= $_SESSION['usuario']['apellido_paterno'] ?> <?= $_SESSION['usuario']['apellido_materno'] ?></h3>
    </div>

</div>

<?php ob_start(); ?>

<script src=""></script>

<?php $scripts = ob_get_clean(); ?>


<?php include_once __DIR__ . "../../layout/footer.php"; ?>