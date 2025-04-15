<?php
include_once __DIR__ . "../../../config/config.php";
include_once __DIR__ . "../../../php/conexion.php";


$titulo = "Registrar Usuario - " . SIGLAS;
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

    <!-- Formulario -->
    <form method="post" id="form_usuario">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label" for="nombre">Nombre</label>
                <input class="form-control form-control-lg rounded-0 border-2" type="text" name="nombre" id="nombre" placeholder="Nombre...">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label" for="apellido_paterno">Apellido Paterno</label>
                <input class="form-control form-control-lg rounded-0 border-2" type="text" name="apellido_paterno" id="apellido_paterno" placeholder="Apellido paterno...">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label" for="apellido_materno">Apellido Materno</label>
                <input class="form-control form-control-lg rounded-0 border-2" type="text" name="apellido_materno" id="apellido_materno" placeholder="Apellido materno...">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label" for="correo">Correo</label>
                <input class="form-control form-control-lg rounded-0 border-2" type="email" name="correo" id="correo" placeholder="Email@example.com">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label" for="contrasenia">Contraseña</label>
                <input class="form-control form-control-lg rounded-0 border-2" type="password" name="contrasenia" id="contrasenia" placeholder="Contraseña...">
            </div>
            <div class="col-md-6 mb-3">
                <label for="role_id" class="form-label">Role</label>
                <select class="form-select form-select-lg rounded-0 border-2" name="role_id" id="role_id">
                    <option value="">Seleccionar Role</option>
                    <?php
                    $sql = $conexion->query("SELECT * FROM roles");
                    while ($dato = $sql->fetch_object()) :
                    ?>
                        <option value="<?= $dato->id ?>"><?= $dato->nombre_role ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-3">
                <a href="<?= URL_RAIZ ?>view/usuarios/" class="btn btn-lg btn-secondary rounded-0 text-uppercase">Volver</a>
                <button class="btn btn-lg btn-primary rounded-0 text-uppercase" type="submit">Crear usuarios</button>
            </div>

        </div>
    </form>

</div>

<?php ob_start(); ?>

<script src="<?= URL_RAIZ ?>js/usuarios/app-create.js"></script>

<?php $scripts = ob_get_clean(); ?>

<?php include_once __DIR__ . "../../layout/footer.php"; ?>