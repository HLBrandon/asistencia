<?php
include_once __DIR__ . "../../../config/config.php";
include_once __DIR__ . "../../../php/conexion.php";

$titulo = "Registrar Estudiante - " . SIGLAS;
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

            <a class="btn btn-outline-secondary" href="<?= URL_RAIZ ?>view/estudiantes/">
                <i class="bi bi-arrow-left-circle me-2"></i>Volver
            </a>

        </div>
    </div>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#estudiante-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Registrar un Estudiante</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#estudiantes-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Registrar varios Estudiantes</button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">

        <div class="tab-pane fade show active" id="estudiante-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
            <div class="card rounded-0 shadow">
                <div class="card-body">
                    <!-- Formulario para registrar un estudiante -->
                    <form method="post" id="form_estudiante">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="matricula">Matrícula</label>
                                <input class="form-control form-control-lg rounded-0 border-2" type="text" name="matricula" id="matricula" placeholder="Matrícula...">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="nombre">Nombre</label>
                                <input class="form-control form-control-lg rounded-0 border-2" type="text" name="nombre" id="nombre" placeholder="Nombre...">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="apellido_pa">Apellido Paterno</label>
                                <input class="form-control form-control-lg rounded-0 border-2" type="text" name="apellido_pa" id="apellido_pa" placeholder="Apellido paterno...">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="apellido_ma">Apellido Materno</label>
                                <input class="form-control form-control-lg rounded-0 border-2" type="text" name="apellido_ma" id="apellido_ma" placeholder="Apellido materno...">
                            </div>
                            <div class="col-md-6 mb-3">
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
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="semestre_id">Semestre</label>
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
                            <div class="col-md-6 mb-3">
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
                            <div class="col-md-6 mb-3">
                                <label for="activo" class="form-label">Activo</label>
                                <select class="form-select form-select-lg rounded-0 border-2" name="activo" id="activo">
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-lg btn-primary rounded-0 text-uppercase" type="submit">Crear Estudiante</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="estudiantes-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
            <div class="card rounded-0 shadow">
                <div class="card-body row">
                    <div class="col-md-6 mb-3">
                        <div class="alert alert-warning rounded-0 h-100">
                            <h4><i class="bi bi-1-circle me-2"></i>Descargar plantilla</h4>
                            <p>Descarga la plantilla para registrar varios estudiantes</p>
                            <a href="<?= URL_RAIZ ?>plantillas/generar_plantilla_estudiantes.php" class="btn btn-sm btn-success rounded-0 text-uppercase"><i class="bi bi-download me-2"></i>Descargar</a>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="alert alert-warning rounded-0 h-100">
                            <h4><i class="bi bi-2-circle me-2"></i>Llenar plantilla</h4>
                            <p>Llenar la plantilla con los datos de los estudiantes. <span class="fw-bold">Respetar los espacios asignados</span></p>
                        </div>
                    </div>
                    <!-- Formulario para registrar varios estudiantes -->
                    <div class="col-md-6 mb-3">
                        <div class="alert alert-warning rounded-0 h-100">
                            <h4><i class="bi bi-3-circle me-2"></i>Subir plantilla</h4>
                            <p>Subir la plantilla con los datos de los estudiantes</p>
                            <form method="post" id="form_estudiantes" enctype="multipart/form-data">
                                <input type="file" name="archivo" id="archivo" class="form-control mb-3">
                                <button class="btn btn-sm btn-primary rounded-0 text-uppercase" type="submit"><i class="bi bi-upload me-2"></i>Subir Plantilla</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php ob_start(); ?>

<script src="<?= URL_RAIZ ?>js/estudiantes/app-create.js"></script>

<?php $scripts = ob_get_clean(); ?>

<?php include_once __DIR__ . "../../layout/footer.php"; ?>