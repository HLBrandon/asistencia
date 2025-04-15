<?php
include_once __DIR__ . "../../../config/config.php";
include_once __DIR__ . "../../../php/conexion.php";

$clase_id = $_GET["id"];
$sql = $conexion->query("SELECT a.nombre_asignatura FROM clases c INNER JOIN asignaturas a ON c.asignatura_id = a.id WHERE c.id = $clase_id");
$titulo = $sql->fetch_object()->nombre_asignatura . " - " . SIGLAS;

include_once __DIR__ . "../../layout/header.php";
?>

<!-- Contenido principal -->
<div class="col-md-9 col-lg-10 ms-sm-auto px-4 main-content">

    <form method="post" id="form_asistencia">

        <!-- Header -->
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
            <div>
                <h1 class="h2"><?= $titulo ?></h1>
                <p class="text-muted">Registrar Asistencia de <?= $titulo ?></p>
                <input type="hidden" name="clase_id" id="clase_id" value="<?= $clase_id ?>">
            </div>
            <div class="action-buttons d-flex gap-2">
                <button class="btn btn-success" type="submit">
                    <i class="bi bi-check-circle me-2"></i>Guardar
                </button>
                <a class="btn btn-outline-secondary" href="<?= URL_RAIZ ?>view/mis-clases/asistencias.php?id=<?= $clase_id ?>">
                    <i class="bi bi-x-circle me-2"></i>Volver
                </a>
            </div>
        </div>

        <!-- Botones de marcar todos -->
        <div class="card mb-4 p-3 rounded-0">
            <div class="d-flex gap-2 mb-3">
                <button type="button" class="btn btn-outline-success" id="marcarTodosPresente">
                    <i class="bi bi-check-all me-2"></i>Marcar Todos Presentes
                </button>
                <button type="button" class="btn btn-outline-danger" id="marcarTodosAusente">
                    <i class="bi bi-x-lg me-2"></i>Marcar Todos Ausentes
                </button>
            </div>

            <h4>Mis Estudiantes</h4>
            <div class="table-responsive small">
                <table class="table table-sm table-striped">
                    <thead>
                        <tr>
                            <th>Matricula</th>
                            <th>Nombre</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">

                        <?php
                        $clase_id = $_GET['id'];
                        $mysqli = $conexion->query("SELECT estudiante_id, e.nombre, e.apellido_pa, e.apellido_ma, e.matricula FROM inscripciones i
                            INNER JOIN estudiantes e ON i.estudiante_id = e.id
                            WHERE i.clase_id = $clase_id
                            ORDER BY e.apellido_pa");
                        while ($dato = $mysqli->fetch_object()) :
                        ?>

                            <tr>
                                <td><?= $dato->matricula ?></td>
                                <td><?= $dato->apellido_pa ?> <?= $dato->apellido_ma ?> <?= $dato->nombre ?></td>
                                <td class="text-start text-sm-center">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="asistencias[<?= $dato->estudiante_id ?>]" id="presente_<?= $dato->estudiante_id ?>" value="1">
                                        <label class="form-check-label" for="presente_<?= $dato->estudiante_id ?>">
                                            Presente
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="asistencias[<?= $dato->estudiante_id ?>]" id="no_presente_<?= $dato->estudiante_id ?>" value="0">
                                        <label class="form-check-label" for="no_presente_<?= $dato->estudiante_id ?>">
                                            No Presente
                                        </label>
                                    </div>
                                </td>
                            </tr>

                        <?php endwhile; ?>

                    </tbody>
                </table>
            </div>
            
        </div>
    </form>

</div>

<?php ob_start(); ?>

<script src="<?= URL_RAIZ ?>js/asistencias/app-create.js"></script>

<?php $scripts = ob_get_clean(); ?>

<?php include_once __DIR__ . "../../layout/footer.php"; ?>