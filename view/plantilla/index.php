<?php

include_once __DIR__ . "../../layout/header.php"

?>

<!-- Contenido principal -->
<div class="col-md-9 col-lg-10 ms-sm-auto px-4 main-content">
    <!-- Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
        <div>
            <h1 class="h2">Dashboard</h1>
            <p class="text-muted">Resumen general</p>
        </div>
        <div class="action-buttons d-flex gap-2">
            <button type="button" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Nuevo
            </button>
            <button type="button" class="btn btn-outline-secondary">
                <i class="bi bi-download"></i> Exportar
            </button>
        </div>
    </div>

    <!-- Tarjetas de estadísticas -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-xl-3">
            <div class="card stat-card bg-primary bg-gradient text-white">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title mb-2">Ingresos</h6>
                            <h3 class="mb-0 fs-5">$84,245</h3>
                            <small>+18.2%</small>
                        </div>
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="card stat-card bg-success bg-gradient text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title mb-3">Nuevos Clientes</h6>
                            <h3 class="mb-0">845</h3>
                            <small>+5.3% vs último mes</small>
                        </div>
                        <div class="fs-1">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="card stat-card bg-warning bg-gradient text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title mb-3">Órdenes Nuevas</h6>
                            <h3 class="mb-0">1,257</h3>
                            <small>+12.4% vs último mes</small>
                        </div>
                        <div class="fs-1">
                            <i class="bi bi-bag-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="card stat-card bg-info bg-gradient text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title mb-3">Visitas</h6>
                            <h3 class="mb-0">45.2K</h3>
                            <small>+22.4% vs último mes</small>
                        </div>
                        <div class="fs-1">
                            <i class="bi bi-eye-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actividad Reciente -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Actividad Reciente</h5>
            <button class="btn btn-sm btn-outline-secondary">Ver Todo</button>
        </div>
        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                <div class="list-group-item p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-person-circle fs-4 me-2"></i>
                            <div>
                                <h6 class="mb-0">Nueva venta</h6>
                                <small class="text-muted">2 min</small>
                            </div>
                        </div>
                        <span class="badge bg-success">$250</span>
                    </div>
                </div>
                <div class="list-group-item p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-person-circle fs-4 me-2"></i>
                            <div>
                                <h6 class="mb-0">Nuevo cliente registrado</h6>
                                <small class="text-muted">hace 15 minutos</small>
                            </div>
                        </div>
                        <span class="badge bg-primary">Nuevo</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php ob_start(); ?>

<script src="<?= URL_RAIZ ?>js/usuarios/app-index-usuario-admin.js"></script>

<?php $scripts = ob_get_clean(); ?>


<?php include_once __DIR__ . "../../layout/footer.php"; ?>