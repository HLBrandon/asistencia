<?php
include_once __DIR__ . "../../../config/config.php";
include_once __DIR__ . "../../../php/conexion.php";

$clase_id = $_GET["id"];
$mes_inicio = $_GET["mes-inicio"];
// Crear un objeto DateTime
$date = new DateTime($mes_inicio);
// Número de días a sumar
$diasASumar = 30;
// Sumar los días
$date->modify("+{$diasASumar} days");
// Formatear la fecha resultante
$mes_fin = $date->format('Y-m-d');

$sql = $conexion->query("SELECT a.nombre_asignatura FROM clases c INNER JOIN asignaturas a ON c.asignatura_id = a.id WHERE c.id = $clase_id");
$titulo = $sql->fetch_object()->nombre_asignatura . " - " . SIGLAS;

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

            <a class="btn btn-outline-secondary" href="<?= URL_RAIZ ?>view/asistencias/ver-meses.php?id=<?= $clase_id ?>">
                <i class="bi bi-arrow-left-circle me-2"></i>Volver
            </a>

        </div>
    </div>

    <!-- Actividad Reciente -->
    <div class="card mb-4 p-3 rounded-0">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Día</th>
                        <th>Hora</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider" id="body-tabla">

                    <?php
                    $mysqli = $conexion->query("SELECT a.id, a.fecha, d.nombre_id, a.hora FROM asistencias a
                    INNER JOIN dias d ON a.dia_id = d.id
                    WHERE a.clase_id = $clase_id AND fecha BETWEEN '$mes_inicio' AND '$mes_fin'");
                    while ($dato = $mysqli->fetch_object()) : ?>
                        <tr>
                            <td><?= $dato->fecha ?></td>
                            <td><?= $dato->nombre_id ?></td>
                            <td><?= $dato->hora ?></td>
                            <td>
                                <a title="Descargar PDF" class="btn btn-sm btn-danger rounded-0" href="<?= URL_RAIZ ?>view/generar-reporte/asistente/reporte-dia.php?asistencia=<?= $dato->id ?>"><i class="bi bi-download me-2"></i>PDF</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>

                </tbody>
            </table>
        </div>
    </div>

</div>

<?php ob_start(); ?>

<script src="<?= URL_RAIZ ?>"></script>

<?php $scripts = ob_get_clean(); ?>

<?php include_once __DIR__ . "../../layout/footer.php"; ?>