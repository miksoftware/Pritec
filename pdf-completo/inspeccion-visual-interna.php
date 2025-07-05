<?php
// Componente: Inspección visual interna (para motocicletas)
// Incluye: Estructura y chasis para motocicletas
?>

<?php if (str_contains($peritaje["tipo_vehiculo"], "MOTOCICLETA")): ?>
  <section class="p-2 rounded my-2" style="border: 1px solid var(--main-color)">
    <div class="d-flex gap-2">
      <div class="yellow-background sub-title-vertical">INSPECCIÓN VISUAL INTERNA</div>
      <div class="d-flex flex-column w-100">
        <div class="yellow-background sub-title w-100">
          VEHÍCULO: <?php echo $peritaje["tipo_vehiculo"]; ?>
        </div>
        <p>Indique con un círculo en que parte del vehículo tiene alguna condición.</p>
        
        <!-- Estructura -->
        <div>
          <div class="yellow-background sub-title ms-4 mb-0">ESTRUCTURA</div>
          <div class="d-flex gap-2 w-100">
            <?php 
            $estructuraUrl = isset($tiposVehiculos[$peritaje["tipo_vehiculo"]]) 
              ? $tiposVehiculos[$peritaje["tipo_vehiculo"]]->urlEstructura 
              : "img/estructura/default.png";
            ?>
            <img src="<?php echo $estructuraUrl; ?>"
              class="w-50" style="object-fit: contain; max-height: 200px">
            <div class="d-flex flex-column gap-2 w-50 h-100">
              <div class="d-flex gap-2">
                <div class="yellow-background label text-center" style="width: 70%">
                  Descripción pieza
                </div>
                <div class="input text-center">
                  Concepto
                </div>
              </div>
              <?php if (!empty($estructura)): ?>
                <?php foreach ($estructura as $fila): ?>
                  <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%">
                      <?php echo htmlspecialchars($fila["descripcion_pieza"]); ?>
                    </div>
                    <div class="input"><?php echo htmlspecialchars($fila["concepto"]); ?></div>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
        
        <!-- Chasis -->
        <div>
          <div class="yellow-background sub-title ms-4 mb-0">CHASIS</div>
          <div class="d-flex gap-2 w-100">
            <?php 
            $chasisUrl = isset($tiposVehiculos[$peritaje["tipo_vehiculo"]]) 
              ? $tiposVehiculos[$peritaje["tipo_vehiculo"]]->urlChasis 
              : "img/chasis/default.png";
            ?>
            <img src="<?php echo $chasisUrl; ?>" class="w-50"
              style="object-fit: contain; max-height: 200px">
            <div class="d-flex flex-column gap-2 w-50 h-100">
              <div class="d-flex gap-2">
                <div class="yellow-background label text-center" style="width: 70%">Descripción
                  pieza
                </div>
                <div class="input text-center">
                  Concepto
                </div>
              </div>
              <?php if (!empty($chasis)): ?>
                <?php foreach ($chasis as $fila): ?>
                  <div class="d-flex gap-2">
                    <div class="yellow-background label" style="width: 70%">
                      <?php echo htmlspecialchars($fila["descripcion_pieza"]); ?>
                    </div>
                    <div class="input"><?php echo htmlspecialchars($fila["concepto"]); ?></div>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
        
        <div class="remarks" style="height: fit-content">
          OBSERVACIONES: <br /> <?php echo $peritaje["observaciones_estructura"]; ?>
        </div>
      </div>
    </div>
  </section>
<?php endif; ?>
