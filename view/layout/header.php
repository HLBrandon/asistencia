<?php
# VERIFICA SI NO HAY UNA SESION
if (empty($_SESSION["usuario"])) {
    header("Location: " . URL_RAIZ); // sI NO HAY SESION TE ENVIA AL LOGIN
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://cdn.datatables.net/v/dt/dt-2.1.8/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= URL_RAIZ ?>css/main.css">

    <script>
        const URL_RAIZ = "<?= URL_RAIZ ?>";
    </script>

</head>

<body class="bg-light">

    <div class="container-fluid">
        <div class="row">
            <!-- Barra de navegación lateral/inferior -->
            <div class="col-auto col-md-3 col-lg-2 px-sm-2 px-0 sidebar">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2">
                    <h3 class="d-flex align-items-center pb-3 mb-md-0 text-decoration-none">
                        <img class="me-2" width="15%" src="<?= URL_RAIZ ?>img/logo_itsmt.png" alt="LOGO_ITSMT"><?= SIGLAS ?>
                    </h3>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start w-100">

                        <li class="nav-item">
                            <a href="<?= URL_RAIZ ?>view/home/" class="nav-link text-dark">
                                <i class="bi bi-house-fill"></i>
                                <span class="ms-2">Inicio</span>
                            </a>
                        </li>

                        <?php if ($_SESSION["usuario"]["role_id"] == 1): ?>
                            <!-- SECCION QUE SOLO EL ADMINISTRADOR PUEDE VER -->
                            <li class="nav-item dropdown">
                                <button class="nav-link text-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Control de Personal
                                </button>
                                <ul class="dropdown-menu">
                                    <li class="nav-item">
                                        <a href="<?= URL_RAIZ ?>view/usuarios/" class="nav-link text-dark">
                                            <i class="bi bi-people"></i>
                                            <span class="ms-2">Usuarios</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= URL_RAIZ ?>view/roles/" class="nav-link text-dark">
                                            <i class="bi bi-people"></i>
                                            <span class="ms-2">Roles</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item dropdown">
                                <button class="nav-link text-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Sistema escolar
                                </button>
                                <ul class="dropdown-menu">
                                    <li class="nav-item">
                                        <a href="<?= URL_RAIZ ?>view/salones/" class="nav-link text-dark">
                                            <i class="bi bi-bookmarks"></i>
                                            <span class="ms-2">Salones</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= URL_RAIZ ?>view/dias/" class="nav-link text-dark">
                                            <i class="bi bi-calendar-day"></i>
                                            <span class="ms-2">Días</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= URL_RAIZ ?>view/carreras/" class="nav-link text-dark">
                                            <i class="bi bi-nut-fill"></i>
                                            <span class="ms-2">Carreras</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= URL_RAIZ ?>view/semestres/" class="nav-link text-dark">
                                            <i class="bi bi-7-square-fill"></i>
                                            <span class="ms-2">Semestres</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= URL_RAIZ ?>view/sistemas/" class="nav-link text-dark">
                                            <i class="bi bi-circle-half"></i>
                                            <span class="ms-2">Sistemas</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= URL_RAIZ ?>view/asignaturas/" class="nav-link text-dark">
                                            <i class="bi bi-book-half"></i>
                                            <span class="ms-2">Asignaturas</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= URL_RAIZ ?>view/periodos/" class="nav-link text-dark">
                                            <i class="bi bi-calendar2-day-fill"></i>
                                            <span class="ms-2">Periodos</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item dropdown">
                                <button class="nav-link text-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Control de Estudiantes
                                </button>
                                <ul class="dropdown-menu">
                                    <li class="nav-item">
                                        <a href="<?= URL_RAIZ ?>view/estudiantes/" class="nav-link text-dark">
                                            <i class="bi bi-pencil-fill"></i>
                                            <span class="ms-2">Estudiantes</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= URL_RAIZ ?>view/clases/" class="nav-link text-dark">
                                            <i class="bi bi-pencil-fill"></i>
                                            <span class="ms-2">Clases</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= URL_RAIZ ?>view/inscripciones/" class="nav-link text-dark">
                                            <i class="bi bi-clipboard-plus-fill"></i>
                                            <span class="ms-2">Inscripciones</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="<?= URL_RAIZ ?>view/backup/" class="nav-link text-dark">
                                    <i class="bi bi-database"></i>
                                    <span class="ms-2">Base de Datos</span>
                                </a>
                            </li>
                        <?php endif ?>

                        <?php if ($_SESSION["usuario"]["role_id"] == 1 or $_SESSION["usuario"]["role_id"] == 3): ?>
                            <!-- SECCION QUE SOLO EL ADMINISTRADOR Y ASISTENTES PUEDE VER -->
                            <li class="nav-item">
                                <a href="<?= URL_RAIZ ?>view/asistencias/" class="nav-link text-dark">
                                    <i class="bi bi-list-task"></i>
                                    <span class="ms-2">Asistencias</span>
                                </a>
                            </li>
                        <?php endif ?>

                        <?php if ($_SESSION["usuario"]["role_id"] == 2): ?>
                            <!-- SECCIÓN SOLO DEL PROFESOR -->
                            <li class="nav-item">
                                <a href="<?= URL_RAIZ ?>view/mis-clases/" class="nav-link text-dark">
                                    <i class="bi bi-list-task"></i>
                                    <span class="ms-2">Mis Clases</span>
                                </a>
                            </li>
                        <?php endif ?>

                        <li class="nav-item">
                            <a href="<?= URL_RAIZ ?>view/configuracion/" class="nav-link text-dark">
                                <i class="bi bi-gear"></i>
                                <span class="ms-2">Configuración</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= URL_RAIZ ?>php/auth/cerrar_sesion.php" class="nav-link text-danger">
                                <i class="bi bi-box-arrow-left"></i>
                                <span class="ms-2">Cerrar Sesión</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>