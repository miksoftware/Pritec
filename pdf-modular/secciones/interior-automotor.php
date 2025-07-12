<?php
/**
 * Sección de Interior del Automotor
 * Muestra información sobre el interior del vehículo
 */

// Verificar que la variable $peritaje esté disponible
if (!isset($peritaje)) {
    throw new Exception("Variable \$peritaje no está disponible en la sección interior automotor");
}

// Definir campos de interior del automotor como en P_peritajeC.php ($tabla3)
$campos_interior = [
    "estado_calefaccion" => "Calefacción",
    "estado_aire_acondicionado" => "Aire acondicionado",
    "estado_cinturones" => "Cinturones",
    "estado_tapiceria_asientos" => "Tapicería asientos",
    "estado_tapiceria_techo" => "Tapicería Techo",
    "estado_millaret" => "Millaret",
    "estado_alfombra" => "Alfombra",
    "estado_chapas" => "Chapas",
];
?>

<section class="seccion-interior-automotor">
    <div class="inspeccion-contenido">
        <div class="fondo-amarillo sub-titulo-vertical">INTERIOR DEL AUTOMOTOR</div>
        
        <div class="inspeccion-detalle">
            <div class="tabla-inspeccion">
                <!-- Header de la tabla -->
                <div class="fila-tabla-header">
                    <div class="header-descripcion">SISTEMA</div>
                    <div class="header-concepto">ESTADO</div>
                    <div class="header-respuesta">RESPUESTA</div>
                </div>
                
                <!-- Filas de datos -->
                <?php foreach ($campos_interior as $campo => $etiqueta): ?>
                    <div class="fila-tabla-datos">
                        <div class="celda-descripcion">
                            <?php echo htmlspecialchars($etiqueta); ?>
                        </div>
                        <div class="celda-concepto">
                            <?php echo htmlspecialchars($peritaje[$campo] ?? ''); ?>
                        </div>
                        <div class="celda-respuesta">
                            <?php echo htmlspecialchars($peritaje[str_replace("estado_", "respuesta_", $campo)] ?? ''); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <!-- Observaciones -->
    <div class="observaciones">
        <strong>OBSERVACIONES:</strong><br>
        <?php echo htmlspecialchars($peritaje["observaciones_interior"] ?? ''); ?>
    </div>
</section>