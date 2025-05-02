<?php
include 'layouts/header.php';
require_once 'conexion/conexion.php';

// Obtener datos reales
$conexion = new Conexion();
$conn = $conexion->conectar();

// Peritajes Básicos
$resBasico = $conn->query("SELECT COUNT(*) as total FROM peritaje_basico");
$basicos = $resBasico ? $resBasico->fetch_assoc()['total'] : 0;

// Peritajes Completos
$resCompleto = $conn->query("SELECT COUNT(*) as total FROM peritaje_completo");
$completos = $resCompleto ? $resCompleto->fetch_assoc()['total'] : 0;

// Peritajes este mes (básicos + completos)
$mesActual = date('m');
$anioActual = date('Y');
$resMes = $conn->query("SELECT 
    (SELECT COUNT(*) FROM peritaje_basico WHERE MONTH(fecha) = $mesActual AND YEAR(fecha) = $anioActual) +
    (SELECT COUNT(*) FROM peritaje_completo WHERE MONTH(fecha) = $mesActual AND YEAR(fecha) = $anioActual) as total
");
$esteMes = $resMes ? $resMes->fetch_assoc()['total'] : 0;

// Obtener peritajes por mes del año actual (básicos + completos)
$meses = [
    1 => 'Enero',
    2 => 'Febrero',
    3 => 'Marzo',
    4 => 'Abril',
    5 => 'Mayo',
    6 => 'Junio',
    7 => 'Julio',
    8 => 'Agosto',
    9 => 'Septiembre',
    10 => 'Octubre',
    11 => 'Noviembre',
    12 => 'Diciembre'
];
$peritajesPorMes = [];
$totalAnual = 0;
for ($m = 1; $m <= 12; $m++) {
    $sql = "
        (SELECT COUNT(*) FROM peritaje_basico WHERE MONTH(fecha) = $m AND YEAR(fecha) = $anioActual)
        +
        (SELECT COUNT(*) FROM peritaje_completo WHERE MONTH(fecha) = $m AND YEAR(fecha) = $anioActual) as total
    ";
    $res = $conn->query("SELECT $sql");
    $total = $res ? intval($res->fetch_assoc()['total']) : 0;
    $peritajesPorMes[$m] = $total;
    $totalAnual += $total;
}

$conn->close();
?>

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
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Peritajes Básicos</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $basicos; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-car fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Peritajes Completos -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Peritajes Completos</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $completos; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Peritajes Este Mes -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Peritajes (Este Mes)</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $esteMes; ?></div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo ($completos + $basicos) > 0 ? intval(($esteMes / max(1, $completos + $basicos)) * 100) : 0; ?>%"
                                            aria-valuenow="<?php echo $esteMes; ?>" aria-valuemin="0" aria-valuemax="<?php echo $completos + $basicos; ?>"></div>
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
    </div>

    <!-- Contenido Principal -->
    <div class="row">
        <!-- Gráfico de peritajes -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Resumen de Peritajes por Mes</h6>
                </div>
                <div class="card-body">
                    <canvas id="peritajesMesChart" height="100"></canvas>
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
                                <?php
                                // Nueva conexión para esta sección si $conn ya fue cerrado
                                $conexionUltimos = new Conexion();
                                $connUltimos = $conexionUltimos->conectar();

                                // Traer los últimos 4 peritajes de ambas tablas
                                $sql = "
                                    SELECT placa, 'Básico' as tipo, fecha, 
                                        IFNULL(estado, 'Completado') as estado
                                    FROM peritaje_basico
                                    UNION ALL
                                    SELECT placa, 'Completo' as tipo, fecha, 
                                        IFNULL(estado, 'Completado') as estado
                                    FROM peritaje_completo
                                    ORDER BY fecha DESC
                                    LIMIT 4
                                ";
                                $resUltimos = $connUltimos->query($sql);
                                if ($resUltimos && $resUltimos->num_rows > 0) {
                                    while ($row = $resUltimos->fetch_assoc()) {
                                        $badge = ($row['estado'] === 'Pendiente') ? 'bg-warning' : 'bg-success';
                                        $estado = ($row['estado'] === 'Pendiente') ? 'Pendiente' : 'Completado';
                                        $fecha = date('d/m/Y', strtotime($row['fecha']));
                                        echo "<tr>
                                            <td>{$row['placa']}</td>
                                            <td>{$row['tipo']}</td>
                                            <td>{$fecha}</td>
                                            <td><span class='badge $badge'>$estado</span></td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='text-center'>No hay peritajes recientes</td></tr>";
                                }
                                $connUltimos->close();
                                ?>
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
        <!-- Actividad reciente -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Actividad Reciente</h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <?php
                        // Conexión para actividad reciente
                        $conexionActividad = new Conexion();
                        $connActividad = $conexionActividad->conectar();

                        // Traer las últimas 6 actividades de ambas tablas
                        $sqlActividad = "
                            SELECT placa, 'Básico' as tipo, fecha, 'creado' as accion
                            FROM peritaje_basico
                            UNION ALL
                            SELECT placa, 'Completo' as tipo, fecha, 'creado' as accion
                            FROM peritaje_completo
                            ORDER BY fecha DESC
                            LIMIT 6
                        ";
                        $resActividad = $connActividad->query($sqlActividad);

                        $iconos = [
                            'creado' => ['bg-primary', 'fa-file-alt', 'Se creó un nuevo peritaje'],
                            'completado' => ['bg-success', 'fa-check', 'Se completó el peritaje'],
                            'observacion' => ['bg-warning', 'fa-exclamation', 'Se registró una observación'],
                            'actualizado' => ['bg-info', 'fa-sync', 'Se actualizó el peritaje'],
                        ];

                        if ($resActividad && $resActividad->num_rows > 0) {
                            while ($row = $resActividad->fetch_assoc()) {
                                // Puedes personalizar la lógica de acción según tus necesidades
                                $accion = $row['accion'];
                                $icon = $iconos[$accion][1] ?? 'fa-file-alt';
                                $bg = $iconos[$accion][0] ?? 'bg-primary';
                                $texto = $iconos[$accion][2] ?? 'Actividad';
                                $fecha = date('d M, Y', strtotime($row['fecha']));
                                echo "<div class='timeline-item mb-3 pb-3 border-bottom'>
                                    <div class='d-flex'>
                                        <div class='flex-shrink-0'>
                                            <div class='icon-circle $bg'>
                                                <i class='fas $icon text-white'></i>
                                            </div>
                                        </div>
                                        <div class='flex-grow-1 ms-3'>
                                            <div class='small text-gray-500'>$fecha</div>
                                            <span>$texto {$row['tipo']} para el vehículo {$row['placa']}</span>
                                        </div>
                                    </div>
                                </div>";
                            }
                        } else {
                            echo "<div class='text-center text-muted'>Sin actividad reciente</div>";
                        }
                        $connActividad->close();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .border-left-primary {
        border-left: 4px solid #4e73df;
    }

    .border-left-success {
        border-left: 4px solid #1cc88a;
    }

    .border-left-info {
        border-left: 4px solid #36b9cc;
    }

    .border-left-warning {
        border-left: 4px solid #f6c23e;
    }

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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('peritajesMesChart').getContext('2d');
    const peritajesMesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_values($meses)); ?>,
            datasets: [{
                label: 'Peritajes',
                data: <?php echo json_encode(array_values($peritajesPorMes)); ?>,
                backgroundColor: [
                    'rgba(78, 115, 223, 0.7)',
                    'rgba(28, 200, 138, 0.7)',
                    'rgba(54, 185, 204, 0.7)',
                    'rgba(246, 194, 62, 0.7)',
                    'rgba(231, 74, 59, 0.7)',
                    'rgba(133, 135, 150, 0.7)',
                    'rgba(78, 115, 223, 0.7)',
                    'rgba(28, 200, 138, 0.7)',
                    'rgba(54, 185, 204, 0.7)',
                    'rgba(246, 194, 62, 0.7)',
                    'rgba(231, 74, 59, 0.7)',
                    'rgba(133, 135, 150, 0.7)'
                ],
                borderRadius: 8,
                borderSkipped: false,
                maxBarThickness: 30
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return ' ' + context.parsed.y + ' peritajes';
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>

<?php include 'layouts/footer.php'; ?>