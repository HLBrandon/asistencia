<?php
include_once __DIR__ . "../../../config/config.php";

$clase_id = (!empty($_GET['clase_id'])) ? $_GET['clase_id'] : "";
$horario_id = (!empty($_GET['horario_id'])) ? $_GET['horario_id'] : "";

if (empty($clase_id)) {
    echo "<h1>No se ha seleccionado ninguna clase</h1>";
    exit;
}

if (empty($horario_id)) {
    echo "<h1>No se ha seleccionado ningún horario</h1>";
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

$titulo = "Editar horario para " . $clase->nombre_asignatura . " - " . $clase->carrera_id . " " . $clase->nombre_sistema;
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
            <a href="<?= URL_RAIZ ?>view/horario/index.php?clase_id=<?= $clase_id ?>" class="btn btn-secondary rounded-0">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <?php
    $mysqli = $conexion->prepare("SELECT * FROM horario WHERE id = ?");
    $mysqli->bind_param("i", $horario_id);
    $mysqli->execute();
    $resultado = $mysqli->get_result();
    if ($horario = $resultado->fetch_object()) : ?>
        <!-- Actividad Reciente -->
        <div class="card mb-4">
            <div class="card-body p-3">
                <form id="form-horario">
                    <input type="hidden" name="horario_id" value="<?= $horario_id ?>">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="dia_id" class="form-label">Día</label>
                            <select class="form-select form-select-lg rounded-0 border-2" name="dia_id" id="dia_id">
                                <option value="">Seleccionar día</option>
                                <?php
                                $sql = $conexion->query("SELECT * FROM dias");
                                while ($dia = $sql->fetch_object()) : ?>
                                    <option value="<?= $dia->id ?>" <?= ($horario->dia_id == $dia->id) ? "selected" : "" ?>><?= $dia->nombre_id ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="hora_inicio" class="form-label">Hora inicio</label>
                            <input type="time" class="form-control form-control-lg rounded-0 border-2" name="hora_inicio" id="hora_inicio" value="<?= $horario->hora_inicio ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="hora_fin" class="form-label">Hora fin</label>
                            <input type="time" class="form-control form-control-lg rounded-0 border-2" name="hora_fin" id="hora_fin" value="<?= $horario->hora_fin ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-lg btn-primary rounded-0 text-uppercase">Actualizar horario</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php ob_start(); ?>

<script src="<?= URL_RAIZ ?>js/horario/app-edit.js"></script>

<?php $scripts = ob_get_clean(); ?>

<?php include_once __DIR__ . "../../layout/footer.php"; ?>