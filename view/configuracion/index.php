<?php
include_once __DIR__ . "../../../config/config.php";
include_once __DIR__ . "../../../php/conexion.php";


$titulo = "Configuración de Perfil - " . SIGLAS;
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
    <form method="post" id="form_perfil">
        <h5>Mi información</h5>
        <div class="row">
            <input class="form-control form-control-lg rounded-0 border-2" type="hidden" name="id" id="id" value="<?= $_SESSION['usuario']['id'] ?>">
            <div class="col-md-6 mb-3">
                <label class="form-label" for="nombre">Nombre</label>
                <input class="form-control form-control-lg rounded-0 border-2" type="text" name="nombre" id="nombre" placeholder="Nombre..." value="<?= $_SESSION['usuario']['nombre'] ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label" for="apellido_paterno">Apellido Paterno</label>
                <input class="form-control form-control-lg rounded-0 border-2" type="text" name="apellido_paterno" id="apellido_paterno" placeholder="Apellido paterno..." value="<?= $_SESSION['usuario']['apellido_paterno'] ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label" for="apellido_materno">Apellido Materno</label>
                <input class="form-control form-control-lg rounded-0 border-2" type="text" name="apellido_materno" id="apellido_materno" placeholder="Apellido materno..." value="<?= $_SESSION['usuario']['apellido_materno'] ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label" for="correo">Correo</label>
                <input class="form-control form-control-lg rounded-0 border-2" type="email" name="correo" id="correo" placeholder="Email@example.com" value="<?= $_SESSION['usuario']['correo'] ?>">
            </div>

            <div class="mb-3">
                <button class="btn btn-lg btn-primary rounded-0 text-uppercase" type="submit">Guardar Cambios</button>
            </div>

        </div>
    </form>

    <br><br>

    <form method="post" id="form_contrasenia">
        <h5>Cambiar mi contraseña</h5>
        <div class="row">
            <input class="form-control form-control-lg rounded-0 border-2" type="hidden" name="id" value="<?= $_SESSION['usuario']['id'] ?>">
            <div class="col-md-6 mb-3">
                <label class="form-label" for="contrasenia">Actual Contraseña</label>
                <input class="form-control form-control-lg rounded-0 border-2" type="password" name="contrasenia" id="contrasenia" placeholder="Mi Contraseña">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label" for="contrasenia_nueva">Nuevo Contraseña</label>
                <input class="form-control form-control-lg rounded-0 border-2" type="password" name="contrasenia_nueva" id="contrasenia_nueva" placeholder="Nueva Contraseña">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label" for="contrasenia_confirmar">Confirma contraseña</label>
                <input class="form-control form-control-lg rounded-0 border-2" type="password" name="contrasenia_confirmar" id="contrasenia_confirmar" placeholder="Confirmar Contraseña">
            </div>

            <div class="mb-3">
                <button class="btn btn-lg btn-primary rounded-0 text-uppercase" type="submit">Confirmar</button>
            </div>

        </div>
    </form>

</div>

<?php ob_start(); ?>

<script src="<?= URL_RAIZ ?>js/configuracion/app-index.js"></script>

<?php $scripts = ob_get_clean(); ?>

<?php include_once __DIR__ . "../../layout/footer.php"; ?>