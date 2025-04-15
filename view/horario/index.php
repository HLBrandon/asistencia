<?php
include_once __DIR__ . "../../../config/config.php";

$clase_id = (!empty($_GET['clase_id'])) ? $_GET['clase_id'] : "";

if (empty($clase_id)) {
    echo "<h1>No se ha seleccionado ninguna clase</h1>";
    exit;
}

include_once __DIR__ . "../../../php/conexion.php";

$mysqli = $conexion->prepare("SELECT c.id, a.nombre_asignatura, si.nombre_sistema, c.carrera_id FROM clases c 
                                JOIN asignaturas a ON c.asignatura_id = a.id
                                JOIN sistemas si ON c.sistema_id = si.id
                                WHERE c.id = ?");
$mysqli->bind_param("i", $clase_id);
$mysqli->execute();
$resultado = $mysqli->get_result();
$clase = $resultado->fetch_object();

$titulo = "Horarios de " . $clase->nombre_asignatura . " - " . $clase->carrera_id . " " . $clase->nombre_sistema;
include_once __DIR__ . "../../layout/header.php"
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
            <a href="<?= URL_RAIZ ?>view/horario/create.php?clase_id=<?= $clase_id ?>" class="btn btn-primary rounded-0">
                <i class="bi bi-plus-lg"></i> Nuevo
            </a>
            <a href="<?= URL_RAIZ ?>view/clases/" class="btn btn-secondary rounded-0">
                <i class="bi bi-arrow-left"></i> Volver
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
                            <th class="text-bg-primary">Día</th>
                            <th class="text-bg-primary">Horas</th>
                            <th class="text-bg-primary">Salón</th>
                            <th class="text-bg-primary">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="body-tabla">
                        <?php
                        $mysqli = $conexion->prepare("SELECT d.nombre_id, d.id, h.hora_inicio, h.hora_fin, s.nombre_salon, h.id FROM horario h
                                INNER JOIN clases c ON h.clase_id = c.id
                                INNER JOIN dias d ON h.dia_id = d.id
                                INNER JOIN salones s ON c.salon_id = s.id
                                WHERE clase_id = ?
                                ORDER BY d.id");
                        $mysqli->bind_param("i", $clase_id);
                        $mysqli->execute();
                        $resultado = $mysqli->get_result();
                        while ($horario = $resultado->fetch_object()) : ?>
                            <tr>
                                <td><?= $horario->nombre_id ?></td>
                                <td><?= date('h:i A', strtotime($horario->hora_inicio)) ?> - <?= date('h:i A', strtotime($horario->hora_fin)) ?></td>
                                <td><?= $horario->nombre_salon ?></td>
                                <td>
                                    <a href="<?= URL_RAIZ ?>view/horario/edit.php?horario_id=<?= $horario->id ?>&clase_id=<?= $clase_id ?>" class="btn btn-warning rounded-0">
                                        <i class="bi bi-pencil-square"></i> Editar
                                    </a>
                                    <button class="btn btn-danger rounded-0" onclick="eliminarHorario(<?= $horario->id ?>)">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php ob_start(); ?>

<script src="<?= URL_RAIZ ?>js/horario/app-index.js"></script>

<?php $scripts = ob_get_clean(); ?>

<?php include_once __DIR__ . "../../layout/footer.php"; ?>