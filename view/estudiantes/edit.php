<?php
include_once __DIR__ . "../../../config/config.php";
include_once __DIR__ . "../../../php/conexion.php";


$titulo = "Editar Estudiante - " . SIGLAS;
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

    $pr = $conexion->prepare("SELECT * FROM estudiantes WHERE id = ? LIMIT 1");
    $pr->bind_param("i", $id);
    $pr->execute();
    $result = $pr->get_result();
    if ($edit = $result->fetch_object()) :
    ?>
        <!-- Formulario -->
        <form method="post" id="form_estudiante">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="matricula">Matrícula</label>
                    <input class="form-control form-control-lg rounded-0 border-2" type="text" name="matricula" id="matricula" placeholder="Matrícula..." value="<?= $edit->matricula ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="nombre">Nombre</label>
                    <input class="form-control form-control-lg rounded-0 border-2" type="text" name="nombre" id="nombre" placeholder="Nombre..." value="<?= $edit->nombre ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="apellido_pa">Apellido Paterno</label>
                    <input class="form-control form-control-lg rounded-0 border-2" type="text" name="apellido_pa" id="apellido_pa" placeholder="Apellido paterno..." value="<?= $edit->apellido_pa ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="apellido_ma">Apellido Materno</label>
                    <input class="form-control form-control-lg rounded-0 border-2" type="text" name="apellido_ma" id="apellido_ma" placeholder="Apellido materno..." value="<?= $edit->apellido_ma ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="carrera_id" class="form-label">Carrera</label>
                    <select class="form-select form-select-lg rounded-0 border-2" name="carrera_id" id="carrera_id">
                        <option value="">Seleccionar Carrera</option>
                        <?php
                        $sql = $conexion->query("SELECT * FROM carreras");
                        while ($dato = $sql->fetch_object()) :
                        ?>
                            <option <?= ($dato->id == $edit->carrera_id) ? 'selected' : '' ?> value="<?= $dato->id ?>"><?= $dato->nombre_carrera ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="semestre_id">Semestre</label>
                    <select class="form-select form-select-lg rounded-0 border-2" name="semestre_id" id="semestre_id">
                        <option value="">Seleccionar Semestre</option>
                        <?php
                        $sql = $conexion->query("SELECT * FROM semestres");
                        while ($dato = $sql->fetch_object()) :
                        ?>
                            <option <?= ($dato->id == $edit->semestre_id) ? 'selected' : '' ?> value="<?= $dato->id ?>"><?= $dato->nombre_semestre ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="sistema_id">Sistema</label>
                    <select class="form-select form-select-lg rounded-0 border-2" name="sistema_id" id="sistema_id">
                        <option value="">Seleccionar Sistema</option>
                        <?php
                        $sql = $conexion->query("SELECT * FROM sistemas");
                        while ($dato = $sql->fetch_object()) :
                        ?>
                            <option <?= ($dato->id == $edit->sistema_id) ? 'selected' : '' ?> value="<?= $dato->id ?>"><?= $dato->nombre_sistema ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="activo" class="form-label">Activo</label>
                    <select class="form-select form-select-lg rounded-0 border-2" name="activo" id="activo">
                        <option value="1" <?= $edit->activo == 1 ? 'selected' : '' ?>>Sí</option>
                        <option value="0" <?= $edit->activo == 0 ? 'selected' : '' ?>>No</option>
                    </select>
                </div>

                <div class="mb-3">
                    <a href="<?= URL_RAIZ ?>view/estudiantes/" class="btn btn-lg btn-secondary rounded-0 text-uppercase">Volver</a>
                    <button class="btn btn-lg btn-primary rounded-0 text-uppercase" type="submit">Guardar cambios</button>
                </div>

            </div>
        </form>
    <?php endif; ?>
</div>

<?php ob_start(); ?>

<script src="<?= URL_RAIZ ?>js/estudiantes/app-edit.js"></script>

<?php $scripts = ob_get_clean(); ?>

<?php include_once __DIR__ . "../../layout/footer.php"; ?>