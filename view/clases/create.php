<?php
include_once __DIR__ . "../../../config/config.php";
include_once __DIR__ . "../../../php/conexion.php";

$titulo = "Registrar Clase - " . SIGLAS;
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
    </div>

    <div class="card-body">
        <form method="post" id="form_clase">
            <!-- Información de la Clase -->
            <div class="row mb-4">
                <h5>Información de la Clase</h5>
                <div class="col-md-6 mb-3">
                    <label for="profesor_id" class="form-label">Profesor</label>
                    <select class="form-select form-select-lg rounded-0 border-2" name="profesor_id" id="profesor_id">
                        <option value="">Seleccionar Profesor</option>
                        <?php
                        $sql = $conexion->query("SELECT id, nombre, apellido_paterno, apellido_materno FROM usuarios WHERE role_id = 2");
                        while ($dato = $sql->fetch_object()) :
                        ?>
                            <option value="<?= $dato->id ?>"><?= $dato->nombre . " " . $dato->apellido_paterno . " " . $dato->apellido_materno ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="asignatura_id" class="form-label">Asignatura</label>
                    <select class="form-select form-select-lg rounded-0 border-2" name="asignatura_id" id="asignatura_id">
                        <option value="">Seleccionar Asignatura</option>
                        <?php
                        $sql = $conexion->query("SELECT * FROM asignaturas ORDER BY nombre_asignatura");
                        while ($dato = $sql->fetch_object()) :
                        ?>
                            <option value="<?= $dato->id ?>"><?= $dato->nombre_asignatura ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="carrera_id" class="form-label">Carrera</label>
                    <select class="form-select form-select-lg rounded-0 border-2" name="carrera_id" id="carrera_id">
                        <option value="">Seleccionar Carrera</option>
                        <?php
                        $sql = $conexion->query("SELECT * FROM carreras");
                        while ($dato = $sql->fetch_object()) :
                        ?>
                            <option value="<?= $dato->id ?>"><?= $dato->nombre_carrera ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="semestre_id" class="form-label">Semestre</label>
                    <select class="form-select form-select-lg rounded-0 border-2" name="semestre_id" id="semestre_id">
                        <option value="">Seleccionar Semestre</option>
                        <?php
                        $sql = $conexion->query("SELECT * FROM semestres");
                        while ($dato = $sql->fetch_object()) :
                        ?>
                            <option value="<?= $dato->id ?>"><?= $dato->nombre_semestre ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="sistema_id">Sistema</label>
                    <select class="form-select form-select-lg rounded-0 border-2" name="sistema_id" id="sistema_id">
                        <option value="">Seleccionar Sistema</option>
                        <?php
                        $sql = $conexion->query("SELECT * FROM sistemas");
                        while ($dato = $sql->fetch_object()) :
                        ?>
                            <option value="<?= $dato->id ?>"><?= $dato->nombre_sistema ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="periodo_id" class="form-label">Periodo</label>
                    <select class="form-select form-select-lg rounded-0 border-2" name="periodo_id" id="periodo_id">
                        <option value="">Seleccionar Periodo</option>
                        <?php
                        $sql = $conexion->query("SELECT * FROM periodos");
                        while ($dato = $sql->fetch_object()) :
                        ?>
                            <option value="<?= $dato->id ?>"><?= $dato->fecha_inicio . " al " . $dato->fecha_fin ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="salon_id" class="form-label">Salón</label>
                    <select class="form-select form-select-lg rounded-0 border-2" name="salon_id" id="salon_id">
                        <option value="">Seleccionar Salón</option>
                        <?php
                        $sql = $conexion->query("SELECT * FROM salones");
                        while ($dato = $sql->fetch_object()) :
                        ?>
                            <option value="<?= $dato->id ?>"><?= $dato->nombre_salon ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="activo" class="form-label">Activo</label>
                    <select class="form-select form-select-lg rounded-0 border-2" name="activo" id="activo">
                        <option value="1">Sí</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>

            <!-- Horarios -->
            <div class="row mb-5">
                <h5>Horarios de Clase</h5>
                <div class="col-12">
                    <div id="horarios-container">
                        <div class="card mb-3 horario-item">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Día</label>
                                        <select class="form-select" name="dia[]">
                                            <option value="">Seleccione un día</option>
                                            <?php
                                            $sql = $conexion->query("SELECT * FROM dias");
                                            while ($dato = $sql->fetch_object()) :
                                            ?>
                                                <option value="<?= $dato->id ?>"><?= $dato->nombre_id ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Hora Inicio</label>
                                        <input type="time" class="form-control" name="hora_inicio[]">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label">Hora Fin</label>
                                        <input type="time" class="form-control" name="hora_fin[]">
                                    </div>
                                    <div class="col-md-2 mb-3 d-flex align-items-end">
                                        <button type="button"
                                            class="btn btn-danger btn-sm eliminar-horario">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success btn-sm" id="agregar-horario">
                        <i class="bi bi-plus"></i> Agregar otro horario
                    </button>
                </div>
            </div>

            <div class="mb-5">
                <button type="submit" class="btn btn-lg btn-primary rounded-0 text-uppercase">Registrar Clase</button>
                <a href="<?= URL_RAIZ ?>view/clases/" class="btn btn-lg btn-secondary rounded-0 text-uppercase">Cancelar</a>
            </div>
        </form>
    </div>

</div>

<?php ob_start(); ?>

<script src="<?= URL_RAIZ ?>js/clases/app-horario.js"></script>
<script src="<?= URL_RAIZ ?>js/clases/app-create.js"></script>

<?php $scripts = ob_get_clean(); ?>

<?php include_once __DIR__ . "../../layout/footer.php"; ?>