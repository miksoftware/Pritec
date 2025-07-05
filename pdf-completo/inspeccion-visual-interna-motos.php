<?php
// Componente: Inspección Visual Interna para motocicletas
// Maneja la inspección visual interna específica para motocicletas
?>

<?php if (str_contains($peritaje["tipo_vehiculo"], "MOTOCICLETA")): ?>
    <section class="p-2 rounded simple-border page-break-inside-avoid">
        <div class="d-flex gap-2">
            <div class="yellow-background sub-title-vertical">INSPECCIÓN VISUAL INTERNA</div>
            <div class="d-flex flex-column w-100">
                <div class="yellow-background sub-title w-100">
                    VEHÍCULO: <?php echo $peritaje["tipo_vehiculo"]; ?>
                </div>
                <p style="font-size: 1rem; margin-bottom: 0.5rem;">Indique con un círculo en que parte del vehículo tiene alguna condición.</p>
                <div>
                    <div class="yellow-background sub-title ms-4 mb-0">CHASIS</div>
                    <div class="d-flex gap-2 w-100" style="height: 280px;">
                        <?php 
                        $chasisUrl = isset($tiposVehiculos[$peritaje["tipo_vehiculo"]]) 
                            ? $tiposVehiculos[$peritaje["tipo_vehiculo"]]->urlChasis 
                            : "img/chasis/default.png";
                        ?>
                        <img src="<?php echo $chasisUrl; ?>"
                             class="w-50" style="object-fit: contain; max-height: 270px;">
                        <div class="d-flex flex-column gap-2 w-50 h-100 overflow-hidden">
                            <div class="d-flex gap-2">
                                <div class="yellow-background label text-center" style="width: 70%; padding: 0.2rem 0.5rem; font-size: 0.9rem;">
                                    Descripción pieza
                                </div>
                                <div class="input text-center" style="padding: 0.2rem 0.5rem; font-size: 0.9rem;">
                                    Concepto
                                </div>
                            </div>
                            <div style="max-height: 230px; overflow-y: auto;">
                                <?php if (!empty($chasis)): ?>
                                    <?php foreach ($chasis as $fila): ?>
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
                <div class="remarks" style="height: 60px; overflow-y: auto; font-size: 1rem;">
                    OBSERVACIONES: <br/> <?php echo $peritaje["observaciones_chasis"]; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
