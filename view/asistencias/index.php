<?php
include_once __DIR__ . "../../../config/config.php";
include_once __DIR__ . "../../../php/conexion.php";

$titulo = "Todas las Clases - " . SIGLAS;
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

    <!-- Actividad Reciente -->
    <div class="card mb-4 p-3 rounded-0">

        <div class="table-responsive">
            <table class="table table-hover" id="tabla-clases">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Asignatura</th>
                        <th>Carrera</th>
                        <th>Semestre</th>
                        <th>Sistema</th>
                        <th>Periodo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $profesor_id = $_SESSION['usuario']['id'];
                    $mysqli = $conexion->query("SELECT c.id, a.nombre_asignatura, c.carrera_id, s.nombre_semestre, si.nombre_sistema, p.fecha_inicio, p.fecha_fin FROM clases c
                                    INNER JOIN asignaturas a ON c.asignatura_id = a.id
                                    INNER JOIN semestres s ON c.semestre_id = s.id
                                    INNER JOIN sistemas si ON c.sistema_id = si.id
                                    INNER JOIN periodos p ON c.periodo_id = p.id
                                    ORDER BY c.id DESC");
                    while ($dato = $mysqli->fetch_object()) : ?>
                        <tr>
                            <td><?= $dato->id ?></td>
                            <td><?= $dato->nombre_asignatura ?></td>
                            <td><?= $dato->carrera_id ?></td>
                            <td><?= $dato->nombre_semestre ?></td>
                            <td><?= $dato->nombre_sistema ?></td>
                            <td><?= ucfirst(strftime('%B %Y', strtotime($dato->fecha_inicio))) ?> - <?= ucfirst(strftime('%B %Y', strtotime($dato->fecha_fin))) ?></td>
                            <td>
                                <a class="btn btn-primary rounded-0 text-uppercase" href="<?= URL_RAIZ ?>view/asistencias/ver-meses.php?id=<?= $dato->id ?>">Abrir</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

    </div>

</div>

<?php ob_start(); ?>

<script src="<?= URL_RAIZ ?>js/asistencias-asistente/datatable.js"></script>

<?php $scripts = ob_get_clean(); ?>

<?php include_once __DIR__ . "../../layout/footer.php"; ?>