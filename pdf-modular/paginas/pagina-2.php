<?php
/**
 * Página 2 del PDF Modular de Peritaje
 * Contiene la inspección visual interna del chasis y llantas/amortiguadores
 */

// Verificar que todas las variables necesarias estén disponibles
$variables_requeridas = ['peritaje', 'chasis', 'tiposVehiculos'];
foreach ($variables_requeridas as $variable) {
    if (!isset($$variable)) {
        throw new Exception("Variable \$$variable no está disponible para la página 2");
    }
}

// Definir número de página
$numeroPagina = 2;
?>

<div class="page">
    <div class="contenido-pagina">
        <!-- Inspección Visual Interna - Chasis -->
        <?php include __DIR__ . '/../secciones/inspeccion-interna-chasis.php'; ?>
        
        <!-- Llantas y Amortiguadores -->
        <?php include __DIR__ . '/../secciones/llantas-amortiguadores.php'; ?>
    </div>
    
    <!-- Pie de página -->
    <?php include __DIR__ . '/../secciones/pie-pagina.php'; ?>
</div>
