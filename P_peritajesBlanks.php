<?php
session_start();

// Verificar sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

include 'layouts/header.php';
?>

<div id="content">
    <div class="container py-5">
        <h2 class="text-center mb-5">Generar Formatos de Peritaje en Blanco</h2>
        
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="row">
                    <!-- Tarjeta para Peritaje Básico -->
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 shadow hover-card">
                            <div class="card-header bg-primary text-white">
                                <h4 class="card-title mb-0">Peritaje Básico</h4>
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    Este formato incluye la información básica del vehículo, datos del solicitante, estado de documentos,
                                    y sección de conceptos e improntas.
                                </p>
                                <ul class="list-group list-group-flush mb-4">
                                    <li class="list-group-item"><i class="fas fa-check text-success me-2"></i> Datos del vehículo y solicitante</li>
                                    <li class="list-group-item"><i class="fas fa-check text-success me-2"></i> Estado de documentos</li>
                                    <li class="list-group-item"><i class="fas fa-check text-success me-2"></i> Conceptos e improntas</li>
                                </ul>
                            </div>
                            <div class="card-footer text-center bg-transparent">
                                <a href="impresion_blanco/blank_peritajeB.php" target="_blank" class="btn btn-primary btn-lg px-5">
                                    <i class="fas fa-print me-2"></i> Imprimir
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tarjeta para Peritaje Completo -->
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 shadow hover-card">
                            <div class="card-header bg-success text-white">
                                <h4 class="card-title mb-0">Peritaje Completo</h4>
                            </div>
                            <div class="card-body">
                                <p class="card-text">
                                    Este formato incluye todas las secciones del peritaje básico más inspección visual externa,
                                    llantas y amortiguadores, prueba de diagnóstico y espacio para fijación fotográfica.
                                </p>
                                <ul class="list-group list-group-flush mb-4">
                                    <li class="list-group-item"><i class="fas fa-check text-success me-2"></i> Datos completos del vehículo</li>
                                    <li class="list-group-item"><i class="fas fa-check text-success me-2"></i> Inspección visual externa</li>
                                    <li class="list-group-item"><i class="fas fa-check text-success me-2"></i> Llantas y amortiguadores</li>
                                    <li class="list-group-item"><i class="fas fa-check text-success me-2"></i> Prueba de diagnóstico</li>
                                </ul>
                            </div>
                            <div class="card-footer text-center bg-transparent">
                                <a href="impresion_blanco/blank_peritajeC.php" target="_blank" class="btn btn-success btn-lg px-5">
                                    <i class="fas fa-print me-2"></i> Imprimir
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <a href="Dashboard.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Volver al Panel
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2) !important;
    }
</style>

<?php include 'layouts/footer.php'; ?>