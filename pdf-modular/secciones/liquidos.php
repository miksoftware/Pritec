<?php
/**
 * Sección de Nivel de Líquidos
 * Muestra información sobre el nivel de líquidos del vehículo
 */

// Verificar que la variable $peritaje esté disponible
if (!isset($peritaje)) {
    throw new Exception("Variable \$peritaje no está disponible en la sección líquidos");
}

// Definir campos de nivel de líquidos como en P_peritajeC.php ($campos_nivel)
$campos_liquidos = [
    "respuesta_viscosidad_aceite_motor" => "Viscosidad aceite motor",
    "respuesta_nivel_refrigerante_motor" => "Nivel refrigerante motor",
    "respuesta_nivel_liquido_frenos" => "Nivel líquido de frenos",
    "respuesta_nivel_agua_limpiavidrios" => "Nivel agua limpiavidrios",
    "respuesta_nivel_aceite_direccion_hidraulica" => "Nivel aceite dirección hidráulica",
    "respuesta_nivel_liquido_embrague" => "Nivel líquido embrague",
    "respuesta_nivel_aceite_motor" => "Nivel aceite motor",
];
?>

<section class="seccion-liquidos">
    <div class="inspeccion-contenido">
        <div class="fondo-amarillo sub-titulo-vertical">NIVEL DE LÍQUIDOS</div>
        
        <div class="inspeccion-detalle">
            <div class="tabla-inspeccion">
                <!-- Header de la tabla -->
                <div class="fila-tabla-header">
                    <div class="header-descripcion">SISTEMA</div>
                    <div class="header-concepto">RESPUESTA</div>
                </div>
                
                <!-- Filas de datos -->
                <?php foreach ($campos_liquidos as $campo => $etiqueta): ?>
                    <div class="fila-tabla-datos">
                        <div class="celda-descripcion">
                            <?php echo htmlspecialchars($etiqueta); ?>
                        </div>
                        <div class="celda-concepto">
                            <?php echo htmlspecialchars($peritaje[$campo] ?? ''); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <!-- Observaciones -->
    <div class="observaciones">
        <strong>OBSERVACIONES:</strong><br>
        <?php echo htmlspecialchars($peritaje["observaciones_liquidos"] ?? ''); ?>
    </div>
</section>