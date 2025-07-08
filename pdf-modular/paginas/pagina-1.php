<?php
/**
 * Página 1 del PDF de Peritaje Completo
 * Contiene: Header, Datos del Vehículo y Solicitante, Inspección Visual Externa e Interna
 */

// Verificar que todas las variables necesarias estén disponibles
$variables_requeridas = ['peritaje', 'carroceria', 'estructura', 'chasis', 'tiposVehiculos'];
foreach ($variables_requeridas as $variable) {
    if (!isset($$variable)) {
        throw new Exception("Variable \$$variable no está disponible para la página 1");
    }
}

// Definir número de página
$numeroPagina = 1;
?>

<div class="page">
    <div class="contenido-pagina">
        <!-- Header con información de la empresa y datos del peritaje -->
        <?php include __DIR__ . '/../secciones/header.php'; ?>
        
        <!-- Datos del vehículo y solicitante -->
        <?php include __DIR__ . '/../secciones/datos-vehiculo.php'; ?>
        
        <!-- Inspección Visual Externa - Carrocería (solo para vehículos que no sean motocicletas) -->
        <?php include __DIR__ . '/../secciones/inspeccion-externa-carroceria.php'; ?>
        
        <!-- Inspección Visual Externa - Estructura (solo para vehículos que no sean motocicletas) -->
        <?php include __DIR__ . '/../secciones/inspeccion-externa-estructura.php'; ?>
        
        <!-- Inspección Visual Interna - Estructura (solo para motocicletas) -->
        <?php include __DIR__ . '/../secciones/inspeccion-interna-estructura-moto.php'; ?>
        
        <!-- Inspección Visual Interna - Chasis (solo para motocicletas) -->
        <?php include __DIR__ . '/../secciones/inspeccion-interna-chasis-moto.php'; ?>
    </div>
    
    <!-- Pie de página -->
    <?php include __DIR__ . '/../secciones/pie-pagina.php'; ?>
</div>
