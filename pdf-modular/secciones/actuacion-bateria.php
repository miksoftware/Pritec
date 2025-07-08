<?php
/**
 * Sección de Actuación de la Batería
 * Contiene la inspección de la batería del vehículo
 */

// Verificar que las variables necesarias estén disponibles
if (!isset($peritaje)) {
    throw new Exception("Variable \$peritaje no está disponible en la sección actuación de batería");
}

// Incluir funciones helper
require_once __DIR__ . '/../helpers/funciones.php';
?>

<section class="inspeccion-visual actuacion-bateria">
    <div class="inspeccion-contenido">
        <div class="fondo-amarillo sub-titulo-vertical">ACTUACIÓN DE LA BATERÍA</div>
        <div class="inspeccion-detalle">
            <!-- Convenciones de Batería -->
            <div class="fondo-amarillo sub-titulo w-100">CONVENCIONES BATERÍA</div>
            
            <!-- Barra de colores -->
            <div class="mx-auto" style="width: 95%;">
                <div class="d-flex" style="margin-bottom: 3px;">
                    <div style="height: 15px; width: 25%; background-color:#ff3933;"></div>
                    <div style="height: 15px; width: 25%; background-color:#ff8a33;"></div>
                    <div style="height: 15px; width: 25%; background-color:#ffff33;"></div>
                    <div style="height: 15px; width: 25%; background-color:#36d048;"></div>
                </div>
                
                <!-- Porcentajes -->
                <div class="d-flex justify-content-between" style="font-size: 0.8rem; margin-bottom: 8px;">
                    <p style="margin: 0;">0%</p>
                    <p style="margin: 0;">100%</p>
                </div>
                
                <!-- Leyendas -->
                <div class="d-flex justify-content-center gap-2" style="font-size: 0.7rem; margin-bottom: 8px;">
                    <div class="d-flex align-items-center gap-1">
                        <div style="width: 12px; height: 12px; background-color:#ff3933;"></div>
                        <span>0-24% Crítico</span>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <div style="width: 12px; height: 12px; background-color:#ff8a33;"></div>
                        <span>25-49% Bajo</span>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <div style="width: 12px; height: 12px; background-color:#ffff33;"></div>
                        <span>50-74% Bueno</span>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <div style="width: 12px; height: 12px; background-color:#36d048;"></div>
                        <span>75-100% Excelente</span>
                    </div>
                </div>
            </div>

            <!-- Sección de Batería -->
            <div class="fondo-amarillo sub-titulo ms-4 mb-0">BATERÍA</div>
            <div class="d-flex gap-2 w-100 altura-inspeccion">
                <img 
                    src="img/BATERIA.png" 
                    class="imagen-vehiculo-pag2"
                    alt="Batería del vehículo">
                
                <div class="tabla-inspeccion">
                    <div class="fila-tabla-header">
                        <div class="header-descripcion">ITEM</div>
                        <div class="header-concepto">CONCEPTO</div>
                        <div class="header-concepto">%</div>
                    </div>
                    
                    <div class="fila-tabla-datos">
                        <div class="celda-descripcion">Prueba de batería</div>
                        <div class="celda-concepto <?php echo obtenerClasePorPorcentaje($peritaje["prueba_bateria"] ?? 0); ?>">
                            <?php echo htmlspecialchars(obtenerEstadoBateriaPorPorcentaje($peritaje["prueba_bateria"] ?? 0)); ?>
                        </div>
                        <div class="celda-concepto <?php echo obtenerClasePorPorcentaje($peritaje["prueba_bateria"] ?? 0); ?>">
                            <?php echo htmlspecialchars($peritaje["prueba_bateria"] ?? '0'); ?>%
                        </div>
                    </div>
                    
                    <div class="fila-tabla-datos">
                        <div class="celda-descripcion">Prueba de arranque</div>
                        <div class="celda-concepto <?php echo obtenerClasePorPorcentaje($peritaje["prueba_arranque"] ?? 0); ?>">
                            <?php echo htmlspecialchars(obtenerEstadoBateriaPorPorcentaje($peritaje["prueba_arranque"] ?? 0)); ?>
                        </div>
                        <div class="celda-concepto <?php echo obtenerClasePorPorcentaje($peritaje["prueba_arranque"] ?? 0); ?>">
                            <?php echo htmlspecialchars($peritaje["prueba_arranque"] ?? '0'); ?>%
                        </div>
                    </div>
                    
                    <div class="fila-tabla-datos">
                        <div class="celda-descripcion">Carga de batería</div>
                        <div class="celda-concepto <?php echo obtenerClasePorPorcentaje($peritaje["carga_bateria"] ?? 0); ?>">
                            <?php echo htmlspecialchars(obtenerEstadoBateriaPorPorcentaje($peritaje["carga_bateria"] ?? 0)); ?>
                        </div>
                        <div class="celda-concepto <?php echo obtenerClasePorPorcentaje($peritaje["carga_bateria"] ?? 0); ?>">
                            <?php echo htmlspecialchars($peritaje["carga_bateria"] ?? '0'); ?>%
                        </div>
                    </div>                    
                </div>
            </div>
            
            <div class="observaciones">
                OBSERVACIONES: <br/> 
                <?php echo htmlspecialchars($peritaje["observaciones_bateria"] ?? ''); ?>
            </div>
        </div>
    </div>
</section>
