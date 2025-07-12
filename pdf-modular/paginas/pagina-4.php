<?php
/**
 * Página 4 del PDF de Peritaje Completo
 */

// Verificar que todas las variables necesarias estén disponibles
$variables_requeridas = ['peritaje'];
foreach ($variables_requeridas as $variable) {
    if (!isset($$variable)) {
        throw new Exception("Variable \$$variable no está disponible para la página 4");
    }
}

// Definir número de página
$numeroPagina = 4;
?>

<div class="page">
    <div class="contenido-pagina">  
        <?php include __DIR__ . '/../secciones/motor.php'; ?>
        <?php include __DIR__ . '/../secciones/interior-automotor.php'; ?>      
        
        <?php include __DIR__ . '/../secciones/fugas.php'; ?>
        <?php include __DIR__ . '/../secciones/estado-componentes.php'; ?>
        
    </div>
    
    <!-- Pie de página -->
    <?php include __DIR__ . '/../secciones/pie-pagina.php'; ?>
</div>