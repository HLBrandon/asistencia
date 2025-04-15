<?php
include_once __DIR__ . "../../../config/config.php";

$clase_id = !empty($_GET["clase"]) ? $_GET["clase"] : "";
if ($clase_id == "") {
    echo "<h1>No se ha seleccionado ninguna clase</h1>";
    exit;
}
include_once __DIR__ . "../../../php/conexion.php";

$sql = $conexion->query("SELECT c.id, a.nombre_asignatura, p.fecha_inicio, p.fecha_fin FROM clases c
                            INNER JOIN asignaturas a ON c.asignatura_id = a.id
                            INNER JOIN periodos p ON c.periodo_id = p.id
                            WHERE c.id = $clase_id");
$resultados = $sql->fetch_object();
$titulo = "Alumnos de " . $resultados->nombre_asignatura . " - " . SIGLAS;
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
            <a href="<?= URL_RAIZ ?>view/inscripciones/" class="btn btn-secondary rounded-0">
                <i class="bi bi-arrow-left-circle me-2"></i>Volver
            </a>
        </div>
    </div>

    <!-- Actividad Reciente -->
    <div class="card mb-4">
        <div class="card-body p-0">
            <div class="table-responsive small">
                <table class="table table-hover" id="tabla-inscripciones">
                    <thead>
                        <tr>
                            <th class="text-bg-primary">Matricula</th>
                            <th class="text-bg-primary">Estudiante</th>
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

<script src="<?= URL_RAIZ ?>js/inscripciones/datatable.js"></script>
<script src="<?= URL_RAIZ ?>js/inscripciones/app-listar-alumnos.js"></script>

<?php $scripts = ob_get_clean(); ?>

<?php include_once __DIR__ . "../../layout/footer.php"; ?>