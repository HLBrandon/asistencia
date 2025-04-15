<?php
include_once __DIR__ . "../../../config/config.php";
include_once __DIR__ . "../../../php/conexion.php";

$titulo = "Mis Clases - " . SIGLAS;
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

    <!-- Actividad Reciente -->
    <div class="card mb-4 p-3 rounded-0">
        <div class="row row-cols-1 row-cols-md-3 g-3">

            <?php
            $profesor_id = $_SESSION['usuario']['id'];
            $mysqli = $conexion->query("SELECT c.id, a.nombre_asignatura, c.carrera_id, s.nombre_semestre, si.nombre_sistema FROM clases c
                                    INNER JOIN asignaturas a ON c.asignatura_id = a.id
                                    INNER JOIN semestres s ON c.semestre_id = s.id
                                    INNER JOIN sistemas si ON c.sistema_id = si.id
                                    INNER JOIN periodos p ON c.periodo_id = p.id
                                    WHERE p.activo <> 0 AND c.profesor_id = $profesor_id");
            while ($dato = $mysqli->fetch_object()) :
            ?>
                <div class="col">
                    <div class="card stat-card-mio rounded-0 shadow-sm h-100">
                        <div class="card-body">
                            <p class="card-text text-secondary"><?= $dato->carrera_id ?> <?= $dato->nombre_semestre ?> Semestre <?= $dato->nombre_sistema ?></p>
                            <h5 class="card-title mb-4"><?= $dato->nombre_asignatura ?></h5>
                            <a href="<?= URL_RAIZ ?>view/mis-clases/asistencias.php?id=<?= $dato->id ?>" class="btn btn-primary rounded-0">Ver listas</a>
                        </div>
                    </div>
                </div>

            <?php endwhile; ?>

        </div>
    </div>

</div>

<?php ob_start(); ?>

<script src="<?= URL_RAIZ ?>"></script>

<?php $scripts = ob_get_clean(); ?>

<?php include_once __DIR__ . "../../layout/footer.php"; ?>