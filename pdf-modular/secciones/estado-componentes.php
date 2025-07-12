<?php
/**
 * Sección de Estado de Componentes
 * Muestra información sobre el estado de componentes del vehículo
 */

// Verificar que la variable $peritaje esté disponible
if (!isset($peritaje)) {
    throw new Exception("Variable \$peritaje no está disponible en la sección estado componentes");
}

// Definir campos de estado de componentes como en P_peritajeC.php ($campos_estado)
$campos_estado_componentes = [
    "respuesta_estado_tanque_silenciador" => "Estado tanque silenciador",
    "respuesta_estado_tubo_exhosto" => "Estado tubo exhosto",
    "respuesta_estado_tanque_catalizador_gases" => "Estado tanque catalizador de gases",
    "respuesta_estado_guardapolvo_caja_direccion" => "Estado guardapolvo caja dirección",
    "respuesta_estado_tuberia_frenos" => "Estado tubería frenos",
];
?>

<section class="seccion-estado-componentes">
    <div class="inspeccion-contenido">
        <div class="fondo-amarillo sub-titulo-vertical">COMPONENTES</div>
        
        <div class="inspeccion-detalle">
            <div class="tabla-inspeccion">
                <!-- Header de la tabla -->
                <div class="fila-tabla-header">
                    <div class="header-descripcion">SISTEMA</div>
                    <div class="header-concepto">RESPUESTA</div>
                </div>
                
                <!-- Filas de datos -->
                <?php foreach ($campos_estado_componentes as $campo => $etiqueta): ?>
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
        <?php echo htmlspecialchars($peritaje["observaciones_estado_componentes"] ?? ''); ?>
    </div>
</section>