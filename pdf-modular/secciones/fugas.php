<?php
/**
 * Sección de Fugas
 * Muestra información sobre fugas del vehículo
 */

// Verificar que la variable $peritaje esté disponible
if (!isset($peritaje)) {
    throw new Exception("Variable \$peritaje no está disponible en la sección fugas");
}

$campos_fugas = [
    "respuesta_fuga_aceite_motor" => "Fuga aceite motor",
    "respuesta_fuga_aceite_caja_velocidades" => "Fuga aceite caja de velocidades",
    "respuesta_fuga_aceite_caja_transmision" => "Fuga aceite caja de transmisión",
    "respuesta_fuga_liquido_frenos" => "Fuga líquido de frenos",
    "respuesta_fuga_aceite_direccion_hidraulica" => "Fuga aceite dirección hidráulica",
    "respuesta_fuga_liquido_bomba_embrague" => "Fuga líquido bomba embrague",
    "respuesta_fuga_tanque_combustible" => "Fuga tanque de combustible",
];
?>

<section class="seccion-fugas">
    <div class="inspeccion-contenido">
        <div class="fondo-amarillo sub-titulo-vertical">FUGAS</div>
        
        <div class="inspeccion-detalle">
            <div class="tabla-inspeccion">
                <!-- Header de la tabla -->
                <div class="fila-tabla-header">
                    <div class="header-descripcion">SISTEMA</div>
                    <div class="header-concepto">RESPUESTA</div>
                </div>
                
                <!-- Filas de datos -->
                <?php foreach ($campos_fugas as $campo => $etiqueta): ?>
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
        <?php echo htmlspecialchars($peritaje["observaciones_fugas"] ?? ''); ?>
    </div>
</section>