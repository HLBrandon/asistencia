<?php
include_once __DIR__ . "../../../config/config.php";
include_once __DIR__ . "../../../php/conexion.php";

$clase_id = $_GET["id"];
$sql = $conexion->query("SELECT c.id, a.nombre_asignatura, p.fecha_inicio, p.fecha_fin FROM clases c
                            INNER JOIN asignaturas a ON c.asignatura_id = a.id
                            INNER JOIN periodos p ON c.periodo_id = p.id
                            WHERE c.id = $clase_id");
$resultados = $sql->fetch_object();
$titulo = $resultados->nombre_asignatura . " - " . SIGLAS;

include_once __DIR__ . "../../layout/header.php";
?>

<!-- Contenido principal -->
<div class="col-md-9 col-lg-10 ms-sm-auto px-4 main-content">
    <!-- Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
        <div>
            <h1 class="h2"><?= $titulo ?></h1>
            <p class="text-muted">Panel de Meses para <?= $titulo ?></p>
        </div>
        <div class="action-buttons d-flex gap-2">

            <a class="btn btn-outline-secondary" href="<?= URL_RAIZ ?>view/asistencias/">
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
                        <th>Mes</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider" id="body-tabla">

                    <?php

                    $timestamp_inicio = strtotime($resultados->fecha_inicio);
                    $mes_inicio = date('n', $timestamp_inicio);

                    $timestamp_fin = strtotime($resultados->fecha_fin);
                    $mes_fin = date('n', $timestamp_fin);

                    $meses = array(
                        1 => 'Enero',
                        2 => 'Febrero',
                        3 => 'Marzo',
                        4 => 'Abril',
                        5 => 'Mayo',
                        6 => 'Junio',
                        7 => 'Julio',
                        8 => 'Agosto',
                        9 => 'Septiembre',
                        10 => 'Octubre',
                        11 => 'Noviembre',
                        12 => 'Diciembre'
                    );

                    for ($i = $mes_inicio; $i <= $mes_fin; $i++) : ?>
                        <tr>
                            <td><?= $meses[$i] ?></td>
                            <td>
                                <a class="btn btn-primary rounded-0 text-uppercase" href="<?= URL_RAIZ ?>view/asistencias/ver-asistencias.php?mes-inicio=<?= date('Y') ?>-<?= ($i<10) ? '0'.$i : $i ?>-01&id=<?= $resultados->id ?>">Ver Listas</a>
                                <a class="btn btn-danger rounded-0 text-uppercase" href="<?= URL_RAIZ ?>view/generar-reporte/asistente/reporte-mes.php?mes-inicio=<?= date('Y') ?>-<?= ($i<10) ? '0'.$i : $i ?>-01&clase=<?= $resultados->id ?>">PDF</a>
                            </td>
                        </tr>
                    <?php endfor; ?>

                </tbody>
            </table>
        </div>

    </div>

</div>

<?php ob_start(); ?>

<script src="<?= URL_RAIZ ?>"></script>

<?php $scripts = ob_get_clean(); ?>

<?php include_once __DIR__ . "../../layout/footer.php"; ?>