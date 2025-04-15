<?php
include_once __DIR__ . "../../../config/config.php";
include_once __DIR__ . "../../../php/conexion.php";

$titulo = "Registrar Inscripción - " . SIGLAS;
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
            <a href="<?= URL_RAIZ ?>view/inscripciones/" class="btn btn-secondary rounded-0">
                <i class="bi bi-arrow-left-circle me-2"></i>Volver
            </a>
        </div>
    </div>

    <form method="post" id="form_inscripcion">

        <div class="row">
            <div class="col-md-5">
                <div class="mb-3">
                    <label class="form-label" for="carrera_id">Carrera</label>
                    <select class="form-select form-select-lg rounded-0" name="carrera_id" id="carrera_id">
                        <option value="" selected>Seleccionar Carrera</option>

                        <?php

                        $mysqli = $conexion->query("SELECT id, nombre_carrera FROM carreras");
                        while ($dato = $mysqli->fetch_object()) :
                        ?>
                            <option value="<?= $dato->id ?>"><?= $dato->nombre_carrera ?></option>
                        <?php endwhile; ?>

                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="semestre_id">Semestre</label>
                    <select class="form-select form-select-lg rounded-0" name="semestre_id" id="semestre_id">
                        <option value="" selected>Seleccionar Semestre</option>

                        <?php
                        $mysqli = $conexion->query("SELECT id, nombre_semestre FROM semestres");
                        while ($dato = $mysqli->fetch_object()) :
                        ?>
                            <option value="<?= $dato->id ?>"><?= $dato->nombre_semestre ?></option>
                        <?php endwhile; ?>

                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="sistema_id">Sistema</label>
                    <select class="form-select form-select-lg rounded-0" name="sistema_id" id="sistema_id">
                        <option value="" selected>Seleccionar Sistema</option>

                        <?php
                        $mysqli = $conexion->query("SELECT id, nombre_sistema FROM sistemas");
                        while ($dato = $mysqli->fetch_object()) :
                        ?>
                            <option value="<?= $dato->id ?>"><?= $dato->nombre_sistema ?></option>
                        <?php endwhile; ?>

                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="clase_id">Clase</label>
                    <select class="form-select form-select-lg rounded-0 border-2" name="clase_id" id="clase_id">
                        <option value="">Seleccionar Clase</option>
                        <?php
                        $sql = $conexion->query("SELECT c.id, a.nombre_asignatura, u.nombre, u.apellido_paterno, u.apellido_materno
                                            FROM clases c
                                            INNER JOIN asignaturas a ON c.asignatura_id = a.id
                                            INNER JOIN usuarios u ON c.profesor_id = u.id");
                        while ($dato = $sql->fetch_object()) :
                        ?>
                            <option value="<?= $dato->id ?>"><?= $dato->nombre_asignatura . " - " . $dato->nombre . " " . $dato->apellido_paterno . " " . $dato->apellido_materno ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <button class="btn btn-lg btn-primary rounded-0 text-uppercase" type="submit">Registrar Inscripción</button>
                </div>


            </div>
            <div class="col-md-7 mb-5">
                <div class="mb-3">
                    <button class="btn btn-sm btn-outline-success rounded-0" id="btn-seleccionar-todo">Seleccionar todo</button>
                    <button class="btn btn-sm btn-outline-danger rounded-0" id="btn-deseleccionar-todo">Deseleccionar todo</button>
                </div>

                <ul class="list-group rounded-0" id="contenedor-alumnos">

                    <li class="list-group-item">
                        <p class="text-center mb-0">No hay alumnos para inscribir</p>
                    </li>

                </ul>
            </div>
        </div>

    </form>

</div>

<?php ob_start(); ?>

<script src="<?= URL_RAIZ ?>js/inscripciones/app-create.js"></script>

<?php $scripts = ob_get_clean(); ?>

<?php include_once __DIR__ . "../../layout/footer.php"; ?>