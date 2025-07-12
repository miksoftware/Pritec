<?php
/**
 * Sección de Tren Motriz y Dirección
 * Muestra información sobre el tren motriz y dirección del vehículo
 */

// Verificar que la variable $peritaje esté disponible
if (!isset($peritaje)) {
    throw new Exception("Variable \$peritaje no está disponible en la sección tren motriz");
}

$campos_tren_motriz = [
    "estado_pastilla_freno" => "Pastilla freno",
    "estado_discos_freno" => "Discos freno", 
    "estado_punta_eje" => "Punta eje",
    "estado_axiales" => "Axiales",
    "estado_terminales" => "Terminales",
    "estado_rotulas" => "Rótulas",
    "estado_tijeras" => "Tijeras",
    "estado_caja_direccion" => "Caja dirección",
    "estado_rodamientos" => "Rodamientos",
    "estado_cardan" => "Cardán",
    "estado_crucetas" => "Crucetas",
];
?>

<section class="seccion-tren-motriz">
    <div class="inspeccion-contenido">
        <div class="fondo-amarillo sub-titulo-vertical">TREN MOTRIZ Y DIRECCIÓN</div>
        
        <div class="inspeccion-detalle">
            <div class="tabla-inspeccion">
                <!-- Header de la tabla -->
                <div class="fila-tabla-header">
                    <div class="header-descripcion">SISTEMA</div>
                    <div class="header-concepto">ESTADO</div>
                    <div class="header-respuesta">RESPUESTA</div>
                </div>
                
                <!-- Filas de datos -->
                <?php foreach ($campos_tren_motriz as $campo => $etiqueta): ?>
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