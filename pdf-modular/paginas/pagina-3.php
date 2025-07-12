<?php
/**
 * Página 3 del PDF de Peritaje Completo
 * Contiene: Actuación de la Batería y Prueba de Scanner
 */

// Verificar que todas las variables necesarias estén disponibles
$variables_requeridas = ['peritaje'];
foreach ($variables_requeridas as $variable) {
    if (!isset($$variable)) {
        throw new Exception("Variable \$$variable no está disponible para la página 3");
    }
}

// Definir número de página
$numeroPagina = 3;
?>

<div class="page">
    <div class="contenido-pagina">
        <!-- Sección de Actuación de la Batería -->
        <?php include __DIR__ . '/../secciones/actuacion-bateria.php'; ?>
        
        <!-- Sección de Prueba de Scanner -->
        <?php include __DIR__ . '/../secciones/prueba-scanner.php'; ?>

        <?php include __DIR__ . '/../secciones/tren-motriz.php'; ?>
        <?php include __DIR__ . '/../secciones/liquidos.php'; ?>
        
        
    </div>
    
    <!-- Pie de página -->
    <?php include __DIR__ . '/../secciones/pie-pagina.php'; ?>
</div>