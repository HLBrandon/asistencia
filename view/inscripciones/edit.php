<?php
include_once __DIR__ . "../../../config/config.php";
include_once __DIR__ . "../../../php/conexion.php";

$titulo = "Editar Inscripción - " . SIGLAS;
include_once __DIR__ . "../../layout/header.php"
?>

<!-- Contenido principal -->
<div class="col-md-9 col-lg-10 ms-sm-auto px-4 main-content">
    <!-- Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap alineamos-center pt-3 pb-2 mb-3">
        <div>
            <h1 class="h2"><?= $titulo ?></h1>
            <p class="text-muted">Panel de <?= $titulo ?></p>
        </div>
    </div>

    <?php

    $id = $_GET["id"];

    $pr = $conexion->prepare("SELECT * FROM inscripciones WHERE id = ? LIMIT 1");
    $pr->bind_param("i", $id);
    $pr->execute();
    $result = $pr->get_result();
    if ($edit = $result->fetch_object()) :
    ?>
        <!-- Formulario -->
        <form method="post" id="form_inscripcion">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="clase_id">Clase</label>
                    <select class="form-select form-select-lg rounded-0 border-2" name="clase_id" id="clase_id">
                        <option value="">Seleccionar Clase</option>
                        <?php
                        $sql = $conexion->query("SELECT c.id, a.nombre_asignatura, u.nombre, u.apellido_paterno, u.apellido_materno
                                                FROM clases c
                                                INNER JOIN asignaturas a ON c.asignatura_id = a.id
                                                INNER JOIN usuarios u ON c.profesor_id = u.id
                                                WHERE u.role_id = 2");
                        while ($dato = $sql->fetch_object()) :
                        ?>
                            <option <?= ($dato->id == $edit->clase_id) ? 'selected' : '' ?> value="<?= $dato->id ?>"><?= $dato->nombre_asignatura . " - " . $dato->nombre . " " . $dato->apellido_paterno . " " . $dato->apellido_materno ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="estudiante_id">Estudiante</label>
                    <select class="form-select form-select-lg rounded-0 border-2" name="estudiante_id" id="estudiante_id">
                        <option value="">Seleccionar Estudiante</option>
                        <?php
                        $sql = $conexion->query("SELECT id, matricula, nombre, apellido_pa, apellido_ma FROM estudiantes");
                        while ($dato = $sql->fetch_object()) :
                        ?>
                            <option <?= ($dato->id == $edit->estudiante_id) ? 'selected' : '' ?> value="<?= $dato->id ?>"><?= $dato->matricula . " - " . $dato->nombre . " " . $dato->apellido_pa . " " . $dato->apellido_ma ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <a href="<?= URL_RAIZ ?>view/inscripciones/" class="btn btn-lg btn-secondary rounded-0 text-uppercase">Volver</a>
                    <button class="btn btn-lg btn-primary rounded-0 text-uppercase" type="submit">Guardar cambios</button>
                </div>

            </div>
        </form>
    <?php endif; ?>
</div>

<?php ob_start(); ?>

<script src="<?= URL_RAIZ ?>js/inscripciones/app-edit.js"></script>

<?php $scripts = ob_get_clean(); ?>

<?php include_once __DIR__ . "../../layout/footer.php"; ?>