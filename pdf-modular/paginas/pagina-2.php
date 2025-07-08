<?php
/**
 * Página 2 del PDF de Peritaje Completo
 * Contiene: Inspección Visual Interna - Chasis
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
        <!-- Inspección Visual Interna - Chasis (solo para vehículos que no sean motocicletas) -->
        <?php include __DIR__ . '/../secciones/inspeccion-interna-chasis.php'; ?>
        
        <!-- Aquí se pueden agregar más secciones para la página 2 en el futuro -->
        
    </div>
    
    <!-- Pie de página -->
    <?php include __DIR__ . '/../secciones/pie-pagina.php'; ?>
</div>
