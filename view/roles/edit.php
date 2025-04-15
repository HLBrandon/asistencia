<?php
include_once __DIR__ . "../../../config/config.php";
include_once __DIR__ . "../../../php/conexion.php";

$titulo = "Editar Rol - " . SIGLAS;
include_once __DIR__ . "../../layout/header.php";
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

    <?php
    $id = $_GET["id"];

    $pr = $conexion->prepare("SELECT * FROM roles WHERE id = ? LIMIT 1");
    $pr->bind_param("i", $id);
    $pr->execute();
    $result = $pr->get_result();
    if ($edit = $result->fetch_object()) :
    ?>

        <!-- Formulario -->
        <form method="post" id="form_rol">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="nombre_role">Nombre del Rol</label>
                    <input class="form-control form-control-lg rounded-0 border-2" type="text" name="nombre_role" id="nombre_role" placeholder="Nombre del Rol..." value="<?= $edit->nombre_role ?>">
                </div>

                <div class="mb-3">
                    <a href="<?= URL_RAIZ ?>view/roles/" class="btn btn-lg btn-secondary rounded-0 text-uppercase">Volver</a>
                    <button class="btn btn-lg btn-primary rounded-0 text-uppercase" type="submit">Guardar Cambios</button>
                </div>

            </div>
        </form>

    <?php endif; ?>

</div>

<?php ob_start(); ?>

<script src="<?= URL_RAIZ ?>js/roles/app-edit.js"></script>

<?php $scripts = ob_get_clean(); ?>

<?php include_once __DIR__ . "../../layout/footer.php"; ?>