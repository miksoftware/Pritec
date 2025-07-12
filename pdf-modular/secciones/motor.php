<?php
/**
 * Sección de Motor
 * Muestra información sobre el motor del vehículo
 */

// Verificar que la variable $peritaje esté disponible
if (!isset($peritaje)) {
    throw new Exception("Variable \$peritaje no está disponible en la sección motor");
}

// Definir campos de motor como en P_peritajeC.php (tabla2)
$campos_motor = [
    "estado_arranque" => "Arranque",
    "estado_radiador" => "Radiador", 
    "estado_carter_motor" => "Carter motor",
    "estado_carter_caja" => "Carter caja",
    "estado_caja_velocidades" => "Caja de velocidades",
    "estado_soporte_caja" => "Soporte caja",
    "estado_soporte_motor" => "Soporte Motor",
    "estado_mangueras_radiador" => "Estado mangueras radiador",
    "estado_correas" => "Estado correas",
    "tension_correas" => "Tensión correas",
    "estado_filtro_aire" => "Estado filtro de aire",
    "estado_externo_bateria" => "Estado externo baterías",
    "estado_soporte_motor" => "Estado soporte motor",
];
?>

<section class="seccion-motor">
    <div class="inspeccion-contenido">
        <div class="fondo-amarillo sub-titulo-vertical">MOTOR</div>
        
        <div class="inspeccion-detalle">
            <div class="tabla-inspeccion">
                <!-- Header de la tabla -->
                <div class="fila-tabla-header">
                    <div class="header-descripcion">SISTEMA</div>
                    <div class="header-concepto">ESTADO</div>
                    <div class="header-respuesta">RESPUESTA</div>
                </div>
                
                <!-- Filas de datos -->
                <?php foreach ($campos_motor as $campo => $etiqueta): ?>
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
        <?php echo htmlspecialchars($peritaje["observaciones_motor"] ?? ''); ?>
    </div>
</section>