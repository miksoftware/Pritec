<?php
// Componente: Inspección Visual Externa
// Maneja la inspección visual externa tanto para vehículos normales como motocicletas
?>

<?php if (!str_contains($peritaje["tipo_vehiculo"], "MOTOCICLETA")): ?>
    <section class="p-2 rounded simple-border page-break-inside-avoid">
        <div class="d-flex gap-2">
            <div class="yellow-background sub-title-vertical">INSPECCIÓN VISUAL EXTERNA</div>
            <div class="d-flex flex-column w-100">
                <div class="yellow-background sub-title w-100">
                    VEHÍCULO: <?php echo $peritaje["tipo_vehiculo"]; ?>
                </div>
                <p style="font-size: 1rem; margin-bottom: 0.5rem;">Indique con un círculo en que parte del vehículo tiene alguna condición.</p>
                <div class="yellow-background sub-title ms-4 mb-0">CARROCERÍA</div>
                <div class="d-flex gap-2 w-100" style="height: 220px;">
                    <?php 
                    $vehiculoUrl = isset($tiposVehiculos[$peritaje["tipo_vehiculo"]]) 
                        ? $tiposVehiculos[$peritaje["tipo_vehiculo"]]->urlCarroceria 
                        : "img/carroceria/default.png";
                    ?>
                    <img
                        src="<?php echo $vehiculoUrl; ?>"
                        class="w-50"
                        style="object-fit: contain; max-height: 210px;">
                    <div class="d-flex flex-column gap-2 w-50 h-100 overflow-hidden">
                        <div class="d-flex gap-2">
                            <div class="yellow-background label text-center" style="width: 70%; padding: 0.2rem 0.5rem; font-size: 0.9rem;">Descripción
                                pieza
                            </div>
                            <div class="input text-center" style="padding: 0.2rem 0.5rem; font-size: 0.9rem;">
                                Concepto
                            </div>
                        </div>
                        <div style="max-height: 170px; overflow-y: auto;">
                            <?php if (!empty($carroceria)): ?>
                                <?php foreach ($carroceria as $fila): ?>
                                    <div class="d-flex gap-2 mb-1">
                                        <div class="yellow-background label" style="width: 70%; font-size: 0.85rem; padding: 0.2rem 0.5rem;">
                                            <?php echo htmlspecialchars($fila["descripcion_pieza"]); ?>
                                        </div>
                                        <div class="input" style="font-size: 0.85rem; padding: 0.2rem 0.5rem;"><?php echo htmlspecialchars($fila["concepto"]); ?></div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="remarks" style="height: 50px; overflow-y: auto; font-size: 1rem;">
                    OBSERVACIONES: <br /> <?php echo htmlspecialchars($peritaje["observaciones_inspeccion"]); ?>
                </div>
            </div>
        </div>
    </section>
<?php else: ?>
    <section class="p-2 rounded simple-border page-break-inside-avoid">
        <div class="d-flex gap-2">
            <div class="yellow-background sub-title-vertical">INSPECCIÓN VISUAL EXTERNA</div>
            <div class="d-flex flex-column w-100">
                <div class="yellow-background sub-title w-100">
                    VEHÍCULO: <?php echo $peritaje["tipo_vehiculo"]; ?>
                </div>
                <p style="font-size: 1rem; margin-bottom: 0.5rem;">Indique con un círculo en que parte del vehículo tiene alguna condición.</p>
                <div>
                    <div class="yellow-background sub-title ms-4 mb-0">ESTRUCTURA</div>
                    <div class="d-flex gap-2 w-100" style="height: 220px;">
                        <?php 
                        $estructuraUrl = isset($tiposVehiculos[$peritaje["tipo_vehiculo"]]) 
                            ? $tiposVehiculos[$peritaje["tipo_vehiculo"]]->urlEstructura 
                            : "img/estructura/default.png";
                        ?>
                        <img src="<?php echo $estructuraUrl; ?>"
                             class="w-50" style="object-fit: contain; max-height: 210px;">
                        <div class="d-flex flex-column gap-2 w-50 h-100 overflow-hidden">
                            <div class="d-flex gap-2">
                                <div class="yellow-background label text-center" style="width: 70%; padding: 0.2rem 0.5rem; font-size: 0.9rem;">
                                    Descripción pieza
                                </div>
                                <div class="input text-center" style="padding: 0.2rem 0.5rem; font-size: 0.9rem;">
                                    Concepto
                                </div>
                            </div>
                            <div style="max-height: 170px; overflow-y: auto;">
                                <?php if (!empty($estructura)): ?>
                                    <?php foreach ($estructura as $fila): ?>
                                        <div class="d-flex gap-2 mb-1">
                                            <div class="yellow-background label" style="width: 70%; font-size: 0.85rem; padding: 0.2rem 0.5rem;">
                                                <?php echo htmlspecialchars($fila["descripcion_pieza"]); ?>
                                            </div>
                                            <div class="input" style="font-size: 0.85rem; padding: 0.2rem 0.5rem;"><?php echo htmlspecialchars($fila["concepto"]); ?></div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="remarks" style="height: 50px; overflow-y: auto; font-size: 1rem;">
                    OBSERVACIONES: <br/> <?php echo htmlspecialchars($peritaje["observaciones_inspeccion"]); ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
