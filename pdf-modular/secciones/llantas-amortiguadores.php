<?php
/**
 * Sección de Llantas y Amortiguadores
 * Contiene la inspección de llantas y amortiguadores del vehículo
 */

// Verificar que las variables necesarias estén disponibles
if (!isset($peritaje)) {
    throw new Exception("Variable \$peritaje no está disponible en la sección llantas y amortiguadores");
}

// Incluir funciones helper
require_once __DIR__ . '/../helpers/funciones.php';

// Determinar si es motocicleta para mostrar imagen correcta
$esMotocicleta = str_contains($peritaje["tipo_vehiculo"], "MOTOCICLETA");
?>

<section class="inspeccion-visual llantas-amortiguadores">
    <div class="inspeccion-contenido">
        <div class="fondo-amarillo sub-titulo-vertical">LLANTAS Y AMORTIGUADORES</div>
        <div class="inspeccion-detalle">
            <!-- Convenciones de Llantas -->
            <div class="fondo-amarillo sub-titulo w-100">CONVENCIONES LLANTA</div>
            
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
                        <span>0-24% Peligroso</span>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <div style="width: 12px; height: 12px; background-color:#ff8a33;"></div>
                        <span>25-49% Precaución</span>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <div style="width: 12px; height: 12px; background-color:#ffff33;"></div>
                        <span>50-74% Seguro</span>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <div style="width: 12px; height: 12px; background-color:#36d048;"></div>
                        <span>75-100% Nuevas</span>
                    </div>
                </div>
            </div>

            <!-- Sección de Llantas -->
            <div class="fondo-amarillo sub-titulo ms-4 mb-0">LLANTAS</div>
            <div class="d-flex gap-2 w-100 altura-inspeccion">
                <img 
                    src="<?php echo $esMotocicleta ? 'img/LLANTAS MOTO.png' : 'img/llantas.png'; ?>" 
                    class="imagen-vehiculo-pag2"
                    alt="Llantas del vehículo">
                
                <div class="tabla-inspeccion">
                    <div class="fila-tabla-header">
                        <div class="header-descripcion">ITEM</div>
                        <div class="header-concepto">CONCEPTO</div>
                        <div class="header-concepto">%</div>
                    </div>
                    
                    <div class="fila-tabla-datos">
                        <div class="celda-descripcion">Llanta anterior izquierda</div>
                        <div class="celda-concepto <?php echo obtenerClasePorPorcentaje($peritaje["llanta_anterior_izquierda"] ?? 0); ?>">
                            <?php echo htmlspecialchars(obtenerEstadoPorPorcentaje($peritaje["llanta_anterior_izquierda"] ?? 0)); ?>
                        </div>
                        <div class="celda-concepto <?php echo obtenerClasePorPorcentaje($peritaje["llanta_anterior_izquierda"] ?? 0); ?>">
                            <?php echo htmlspecialchars($peritaje["llanta_anterior_izquierda"] ?? '0'); ?>%
                        </div>
                    </div>
                    
                    <div class="fila-tabla-datos">
                        <div class="celda-descripcion">Llanta anterior derecha</div>
                        <div class="celda-concepto <?php echo obtenerClasePorPorcentaje($peritaje["llanta_anterior_derecha"] ?? 0); ?>">
                            <?php echo htmlspecialchars(obtenerEstadoPorPorcentaje($peritaje["llanta_anterior_derecha"] ?? 0)); ?>
                        </div>
                        <div class="celda-concepto <?php echo obtenerClasePorPorcentaje($peritaje["llanta_anterior_derecha"] ?? 0); ?>">
                            <?php echo htmlspecialchars($peritaje["llanta_anterior_derecha"] ?? '0'); ?>%
                        </div>
                    </div>
                    
                    <div class="fila-tabla-datos">
                        <div class="celda-descripcion">Llanta posterior izquierda</div>
                        <div class="celda-concepto <?php echo obtenerClasePorPorcentaje($peritaje["llanta_posterior_izquierda"] ?? 0); ?>">
                            <?php echo htmlspecialchars(obtenerEstadoPorPorcentaje($peritaje["llanta_posterior_izquierda"] ?? 0)); ?>
                        </div>
                        <div class="celda-concepto <?php echo obtenerClasePorPorcentaje($peritaje["llanta_posterior_izquierda"] ?? 0); ?>">
                            <?php echo htmlspecialchars($peritaje["llanta_posterior_izquierda"] ?? '0'); ?>%
                        </div>
                    </div>
                    
                    <div class="fila-tabla-datos">
                        <div class="celda-descripcion">Llanta posterior derecha</div>
                        <div class="celda-concepto <?php echo obtenerClasePorPorcentaje($peritaje["llanta_posterior_derecha"] ?? 0); ?>">
                            <?php echo htmlspecialchars(obtenerEstadoPorPorcentaje($peritaje["llanta_posterior_derecha"] ?? 0)); ?>
                        </div>
                        <div class="celda-concepto <?php echo obtenerClasePorPorcentaje($peritaje["llanta_posterior_derecha"] ?? 0); ?>">
                            <?php echo htmlspecialchars($peritaje["llanta_posterior_derecha"] ?? '0'); ?>%
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="observaciones">
                OBSERVACIONES: <br/> 
                <?php echo htmlspecialchars($peritaje["observaciones_llantas"] ?? ''); ?>
            </div>
        </div>
    </div>
</section>

<!-- Sección de Amortiguadores -->
<section class="inspeccion-visual llantas-amortiguadores">
    <div class="inspeccion-contenido">
        <div class="fondo-amarillo sub-titulo-vertical">CONVENCIONES AMORTIGUADORES</div>
        <div class="inspeccion-detalle">
            <!-- Barra de colores para amortiguadores -->
            <div class="mx-auto" style="width: 95%;">
                <div class="d-flex" style="margin-bottom: 3px;">
                    <div style="height: 15px; width: 25%; background-color:#ff3933;"></div>
                    <div style="height: 15px; width: 25%; background-color:#ff8a33;"></div>
                    <div style="height: 15px; width: 25%; background-color:#ffff33;"></div>
                    <div style="height: 15px; width: 25%; background-color:#36d048;"></div>
                </div>
                
                <div class="d-flex justify-content-between" style="font-size: 0.8rem; margin-bottom: 8px;">
                    <p style="margin: 0;">0%</p>
                    <p style="margin: 0;">100%</p>
                </div>
                
                <div class="d-flex justify-content-center gap-2" style="font-size: 0.7rem; margin-bottom: 8px;">
                    <div class="d-flex align-items-center gap-1">
                        <div style="width: 12px; height: 12px; background-color:#ff3933;"></div>
                        <span>0-24% Pésimo</span>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <div style="width: 12px; height: 12px; background-color:#ff8a33;"></div>
                        <span>25-49% Supervisión</span>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <div style="width: 12px; height: 12px; background-color:#ffff33;"></div>
                        <span>50-74% Bueno</span>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <div style="width: 12px; height: 12px; background-color:#36d048;"></div>
                        <span>75-100% Nuevos</span>
                    </div>
                </div>
            </div>

            <!-- Sección de Amortiguadores -->
            <div class="fondo-amarillo sub-titulo ms-4 mb-0">AMORTIGUADORES</div>
            <div class="d-flex gap-2 w-100 altura-inspeccion">
                <img 
                    src="<?php echo $esMotocicleta ? 'img/AMORTIGUADORES MOTO.png' : 'img/amortiguadores.png'; ?>" 
                    class="imagen-vehiculo-pag2"
                    alt="Amortiguadores del vehículo">
                
                <div class="tabla-inspeccion">
                    <div class="fila-tabla-header">
                        <div class="header-descripcion">ITEM</div>
                        <div class="header-concepto">CONCEPTO</div>
                        <div class="header-concepto">%</div>
                    </div>
                    
                    <div class="fila-tabla-datos">
                        <div class="celda-descripcion">Amortiguador anterior izquierdo</div>
                        <div class="celda-concepto <?php echo obtenerClasePorPorcentaje($peritaje["amortiguador_anterior_izquierdo"] ?? 0); ?>">
                            <?php echo htmlspecialchars(obtenerEstadoPorPorcentaje($peritaje["amortiguador_anterior_izquierdo"] ?? 0)); ?>
                        </div>
                        <div class="celda-concepto <?php echo obtenerClasePorPorcentaje($peritaje["amortiguador_anterior_izquierdo"] ?? 0); ?>">
                            <?php echo htmlspecialchars($peritaje["amortiguador_anterior_izquierdo"] ?? '0'); ?>%
                        </div>
                    </div>
                    
                    <div class="fila-tabla-datos">
                        <div class="celda-descripcion">Amortiguador anterior derecho</div>
                        <div class="celda-concepto <?php echo obtenerClasePorPorcentaje($peritaje["amortiguador_anterior_derecho"] ?? 0); ?>">
                            <?php echo htmlspecialchars(obtenerEstadoPorPorcentaje($peritaje["amortiguador_anterior_derecho"] ?? 0)); ?>
                        </div>
                        <div class="celda-concepto <?php echo obtenerClasePorPorcentaje($peritaje["amortiguador_anterior_derecho"] ?? 0); ?>">
                            <?php echo htmlspecialchars($peritaje["amortiguador_anterior_derecho"] ?? '0'); ?>%
                        </div>
                    </div>
                    
                    <div class="fila-tabla-datos">
                        <div class="celda-descripcion">Amortiguador posterior izquierdo</div>
                        <div class="celda-concepto <?php echo obtenerClasePorPorcentaje($peritaje["amortiguador_posterior_izquierdo"] ?? 0); ?>">
                            <?php echo htmlspecialchars(obtenerEstadoPorPorcentaje($peritaje["amortiguador_posterior_izquierdo"] ?? 0)); ?>
                        </div>
                        <div class="celda-concepto <?php echo obtenerClasePorPorcentaje($peritaje["amortiguador_posterior_izquierdo"] ?? 0); ?>">
                            <?php echo htmlspecialchars($peritaje["amortiguador_posterior_izquierdo"] ?? '0'); ?>%
                        </div>
                    </div>
                    
                    <div class="fila-tabla-datos">
                        <div class="celda-descripcion">Amortiguador posterior derecho</div>
                        <div class="celda-concepto <?php echo obtenerClasePorPorcentaje($peritaje["amortiguador_posterior_derecho"] ?? 0); ?>">
                            <?php echo htmlspecialchars(obtenerEstadoPorPorcentaje($peritaje["amortiguador_posterior_derecho"] ?? 0)); ?>
                        </div>
                        <div class="celda-concepto <?php echo obtenerClasePorPorcentaje($peritaje["amortiguador_posterior_derecho"] ?? 0); ?>">
                            <?php echo htmlspecialchars($peritaje["amortiguador_posterior_derecho"] ?? '0'); ?>%
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="observaciones">
                OBSERVACIONES: <br/> 
                <?php echo htmlspecialchars($peritaje["observaciones_amortiguadores"] ?? ''); ?>
            </div>
        </div>
    </div>
</section>