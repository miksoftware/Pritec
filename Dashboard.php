<?php include 'layouts/header.php'; ?>

<div id="content" class="container-fluid py-4">
    <!-- Encabezado del Dashboard -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard PRITEC</h1>
        <div>
            <button class="btn btn-primary btn-sm me-2">
                <i class="fas fa-download fa-sm me-2"></i>Generar Reporte
            </button>
            <button class="btn btn-success btn-sm">
                <i class="fas fa-plus fa-sm me-2"></i>Nuevo Peritaje
            </button>
        </div>
    </div>

    <!-- Tarjetas de resumen -->
    <div class="row">
        <!-- Peritajes Básicos -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Peritajes Básicos</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">52</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-car fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Peritajes Completos -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Peritajes Completos</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">38</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Peritajes Este Mes -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Peritajes (Este Mes)</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">12</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                            aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Peritajes Pendientes -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pendientes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">5</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="row">
        <!-- Gráfico de peritajes -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Resumen de Peritajes</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Opciones:</div>
                            <a class="dropdown-item" href="#">Ver Detalles</a>
                            <a class="dropdown-item" href="#">Exportar Datos</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <div class="d-flex justify-content-center align-items-center" style="height:300px">
                            <div class="text-center">
                                <i class="fas fa-chart-line fa-3x mb-3 text-gray-300"></i>
                                <p class="mb-0">Estadísticas por mes</p>
                                <div class="mt-3">
                                    <div class="progress mb-2">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">Enero</div>
                                    </div>
                                    <div class="progress mb-2">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">Febrero</div>
                                    </div>
                                    <div class="progress mb-2">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">Marzo</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjeta de acciones rápidas -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Acciones Rápidas</h6>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="C_peritajeB.php" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Crear Peritaje Básico</h5>
                                <i class="fas fa-arrow-right"></i>
                            </div>
                            <p class="mb-1">Iniciar un nuevo formato de peritaje básico</p>
                        </a>
                        <a href="C_peritajeC.php" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Crear Peritaje Completo</h5>
                                <i class="fas fa-arrow-right"></i>
                            </div>
                            <p class="mb-1">Iniciar un nuevo formato de peritaje completo</p>
                        </a>
                        <a href="P_peritajesBlanks.php" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1">Formatos en Blanco</h5>
                                <i class="fas fa-arrow-right"></i>
                            </div>
                            <p class="mb-1">Descargar formatos en blanco para impresión</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Últimos peritajes y Actividad reciente -->
    <div class="row">
        <!-- Últimos peritajes -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Últimos Peritajes</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Placa</th>
                                    <th>Tipo</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>ABC123</td>
                                    <td>Básico</td>
                                    <td>15/03/2025</td>
                                    <td><span class="badge bg-success">Completado</span></td>
                                </tr>
                                <tr>
                                    <td>XYZ987</td>
                                    <td>Completo</td>
                                    <td>14/03/2025</td>
                                    <td><span class="badge bg-success">Completado</span></td>
                                </tr>
                                <tr>
                                    <td>DEF456</td>
                                    <td>Básico</td>
                                    <td>13/03/2025</td>
                                    <td><span class="badge bg-warning">Pendiente</span></td>
                                </tr>
                                <tr>
                                    <td>GHI789</td>
                                    <td>Completo</td>
                                    <td>10/03/2025</td>
                                    <td><span class="badge bg-success">Completado</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <a href="L_peritajeB.php" class="btn btn-sm btn-primary">
                            Ver todos los peritajes <i class="fas fa-chevron-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actividad reciente -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Actividad Reciente</h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item mb-3 pb-3 border-bottom">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-file-alt text-white"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="small text-gray-500">16 Marzo, 2025</div>
                                    <span>Se creó un nuevo peritaje básico para el vehículo ABC123</span>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item mb-3 pb-3 border-bottom">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <div class="icon-circle bg-success">
                                        <i class="fas fa-check text-white"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="small text-gray-500">15 Marzo, 2025</div>
                                    <span>Se completó el peritaje completo para el vehículo XYZ987</span>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item mb-3 pb-3 border-bottom">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <div class="icon-circle bg-warning">
                                        <i class="fas fa-exclamation text-white"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="small text-gray-500">14 Marzo, 2025</div>
                                    <span>Se registró una observación para el vehículo DEF456</span>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <div class="icon-circle bg-info">
                                        <i class="fas fa-sync text-white"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="small text-gray-500">13 Marzo, 2025</div>
                                    <span>Se actualizó el peritaje básico del vehículo GHI789</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.border-left-primary { border-left: 4px solid #4e73df; }
.border-left-success { border-left: 4px solid #1cc88a; }
.border-left-info { border-left: 4px solid #36b9cc; }
.border-left-warning { border-left: 4px solid #f6c23e; }
.icon-circle {
    height: 40px;
    width: 40px;
    border-radius: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.timeline-item {
    position: relative;
}
</style>

<?php include 'layouts/footer.php'; ?>