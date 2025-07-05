<?php
// Componente: Llantas y amortiguadores
// Incluye: Inspección de llantas y amortiguadores con porcentajes y convenciones
?>

<!-- CONVENCIONES LLANTA -->
<section style="border: 1px solid var(--main-color); padding: 10px; margin: 8px 0;">
  <div class="yellow-background text-center" style="font-weight: bold; padding: 8px; font-size: 1.1rem;">CONVENCIONES LLANTA</div>
  
  <!-- Barra de porcentaje -->
  <div style="margin: 15px 0;">
    <div class="d-flex align-items-center" style="margin-bottom: 8px;">
      <span style="font-size: 0.9rem; width: 40px;">0%</span>
      <div class="flex-grow-1" style="height: 20px; border: 1px solid #000; display: flex;">
        <div style="background: #ff0000; width: 25%; height: 100%;"></div>
        <div style="background: #ff8000; width: 25%; height: 100%;"></div>
        <div style="background: #ffff00; width: 25%; height: 100%;"></div>
        <div style="background: #00ff00; width: 25%; height: 100%;"></div>
      </div>
      <span style="font-size: 0.9rem; width: 45px; text-align: right;">100%</span>
    </div>
    
    <!-- Leyenda debajo de la barra -->
    <div style="display: flex; justify-content: space-between; font-size: 0.75rem; margin-top: 5px;">
      <div style="display: flex; align-items: center; width: 23%;">
        <div style="width: 12px; height: 12px; background: #ff0000; margin-right: 4px;"></div>
        <span>0-24% Peligroso: Cambio la llanta pronto</span>
      </div>
      <div style="display: flex; align-items: center; width: 23%;">
        <div style="width: 12px; height: 12px; background: #ff8000; margin-right: 4px;"></div>
        <span>25-49% Precaución: Considere cambiar la llanta pronto</span>
      </div>
      <div style="display: flex; align-items: center; width: 23%;">
        <div style="width: 12px; height: 12px; background: #ffff00; margin-right: 4px;"></div>
        <span>50-74% Seguir: Desgaste bajo</span>
      </div>
      <div style="display: flex; align-items: center; width: 23%;">
        <div style="width: 12px; height: 12px; background: #00ff00; margin-right: 4px;"></div>
        <span>75-100% Normal: No necesita reemplazo</span>
      </div>
    </div>
  </div>
</section>

<!-- LLANTAS -->
<section style="border: 1px solid var(--main-color); padding: 10px; margin: 8px 0;">
  <div class="d-flex" style="gap: 10px;">
    <div class="yellow-background" style="writing-mode: vertical-rl; text-orientation: mixed; padding: 8px; font-weight: bold; font-size: 0.9rem; display: flex; align-items: center; justify-content: center; min-width: 35px;">LLANTAS Y AMORTIGUADORES</div>
    <div style="flex: 1;">
      <div class="yellow-background text-center" style="font-weight: bold; padding: 8px; font-size: 1.1rem;">LLANTAS</div>
      
      <div class="d-flex" style="gap: 15px; margin-top: 8px;">
        <!-- Imagen -->
        <div style="width: 120px; display: flex; align-items: center; justify-content: center;">
          <?php if (str_contains($peritaje["tipo_vehiculo"], "MOTOCICLETA")): ?>
            <img src="img/LLANTAS%20MOTO.png" style="max-width: 100%; max-height: 120px; object-fit: contain;">
          <?php else: ?>
            <img src="img/llantas.png" style="max-width: 100%; max-height: 120px; object-fit: contain;">
          <?php endif; ?>
        </div>
        
        <!-- Tabla -->
        <div style="flex: 1;">
          <!-- Headers -->
          <div class="d-flex" style="gap: 3px; margin-bottom: 4px;">
            <div class="yellow-background text-center" style="flex: 4; padding: 6px; font-size: 0.9rem; font-weight: bold;">ITEM</div>
            <div class="yellow-background text-center" style="flex: 3; padding: 6px; font-size: 0.9rem; font-weight: bold;">CONCEPTO</div>
            <div class="yellow-background text-center" style="flex: 2; padding: 6px; font-size: 0.9rem; font-weight: bold;">PORCENTAJE</div>
          </div>
          
          <!-- Filas -->
          <div class="d-flex" style="gap: 3px; margin-bottom: 3px;">
            <div class="input text-center" style="flex: 4; padding: 5px; font-size: 0.8rem;">Llanta anterior izquierda</div>
            <div class="input text-center" style="flex: 3; padding: 5px; font-size: 0.8rem;"><?php echo getStateByPercent($peritaje["llanta_anterior_izquierda"]); ?></div>
            <div class="input text-center" style="flex: 2; padding: 5px; font-size: 0.8rem; color: <?php echo getColorByPercent($peritaje["llanta_anterior_izquierda"]); ?>; font-weight: bold;"><?php echo $peritaje["llanta_anterior_izquierda"]; ?>%</div>
          </div>
          
          <div class="d-flex" style="gap: 3px; margin-bottom: 3px;">
            <div class="input text-center" style="flex: 4; padding: 5px; font-size: 0.8rem;">Llanta anterior derecha</div>
            <div class="input text-center" style="flex: 3; padding: 5px; font-size: 0.8rem;"><?php echo getStateByPercent($peritaje["llanta_anterior_derecha"]); ?></div>
            <div class="input text-center" style="flex: 2; padding: 5px; font-size: 0.8rem; color: <?php echo getColorByPercent($peritaje["llanta_anterior_derecha"]); ?>; font-weight: bold;"><?php echo $peritaje["llanta_anterior_derecha"]; ?>%</div>
          </div>
          
          <div class="d-flex" style="gap: 3px; margin-bottom: 3px;">
            <div class="input text-center" style="flex: 4; padding: 5px; font-size: 0.8rem;">Llanta posterior izquierda</div>
            <div class="input text-center" style="flex: 3; padding: 5px; font-size: 0.8rem;"><?php echo getStateByPercent($peritaje["llanta_posterior_izquierda"]); ?></div>
            <div class="input text-center" style="flex: 2; padding: 5px; font-size: 0.8rem; color: <?php echo getColorByPercent($peritaje["llanta_posterior_izquierda"]); ?>; font-weight: bold;"><?php echo $peritaje["llanta_posterior_izquierda"]; ?>%</div>
          </div>
          
          <div class="d-flex" style="gap: 3px;">
            <div class="input text-center" style="flex: 4; padding: 5px; font-size: 0.8rem;">Llanta posterior derecha</div>
            <div class="input text-center" style="flex: 3; padding: 5px; font-size: 0.8rem;"><?php echo getStateByPercent($peritaje["llanta_posterior_derecha"]); ?></div>
            <div class="input text-center" style="flex: 2; padding: 5px; font-size: 0.8rem; color: <?php echo getColorByPercent($peritaje["llanta_posterior_derecha"]); ?>; font-weight: bold;"><?php echo $peritaje["llanta_posterior_derecha"]; ?>%</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CONVENCIONES AMORTIGUADORES -->
<section style="border: 1px solid var(--main-color); padding: 10px; margin: 8px 0;">
  <div class="yellow-background text-center" style="font-weight: bold; padding: 8px; font-size: 1.1rem;">CONVENCIONES AMORTIGUADORES</div>
  
  <!-- Barra de porcentaje -->
  <div style="margin: 15px 0;">
    <div class="d-flex align-items-center" style="margin-bottom: 8px;">
      <span style="font-size: 0.9rem; width: 40px;">0%</span>
      <div class="flex-grow-1" style="height: 20px; border: 1px solid #000; display: flex;">
        <div style="background: #ff0000; width: 25%; height: 100%;"></div>
        <div style="background: #ff8000; width: 25%; height: 100%;"></div>
        <div style="background: #ffff00; width: 25%; height: 100%;"></div>
        <div style="background: #00ff00; width: 25%; height: 100%;"></div>
      </div>
      <span style="font-size: 0.9rem; width: 45px; text-align: right;">100%</span>
    </div>
    
    <!-- Leyenda debajo de la barra -->
    <div style="display: flex; justify-content: space-between; font-size: 0.75rem; margin-top: 5px;">
      <div style="display: flex; align-items: center; width: 23%;">
        <div style="width: 12px; height: 12px; background: #ff0000; margin-right: 4px;"></div>
        <span>0-24% Peligroso: Pérdida de amortiguador de oscilación, ventilador inmediatamente</span>
      </div>
      <div style="display: flex; align-items: center; width: 23%;">
        <div style="width: 12px; height: 12px; background: #ff8000; margin-right: 4px;"></div>
        <span>25-49% Precaución: La reacción del amortiguador durante accesorios eventos</span>
      </div>
      <div style="display: flex; align-items: center; width: 23%;">
        <div style="width: 12px; height: 12px; background: #ffff00; margin-right: 4px;"></div>
        <span>50-74% Seguir: Leve pérdida de desempeño</span>
      </div>
      <div style="display: flex; align-items: center; width: 23%;">
        <div style="width: 12px; height: 12px; background: #00ff00; margin-right: 4px;"></div>
        <span>75-100% Normal: Funcionan correctamente</span>
      </div>
    </div>
  </div>
</section>

<!-- AMORTIGUADORES -->
<section style="border: 1px solid var(--main-color); padding: 10px; margin: 8px 0;">
  <div class="d-flex" style="gap: 10px;">
    <div class="yellow-background" style="writing-mode: vertical-rl; text-orientation: mixed; padding: 8px; font-weight: bold; font-size: 0.9rem; display: flex; align-items: center; justify-content: center; min-width: 35px;">LLANTAS Y AMORTIGUADORES</div>
    <div style="flex: 1;">
      <div class="yellow-background text-center" style="font-weight: bold; padding: 8px; font-size: 1.1rem;">AMORTIGUADORES</div>
      
      <div class="d-flex" style="gap: 15px; margin-top: 8px;">
        <!-- Imagen -->
        <div style="width: 120px; display: flex; align-items: center; justify-content: center;">
          <?php if (str_contains($peritaje["tipo_vehiculo"], "MOTOCICLETA")): ?>
            <img src="img/AMORTIGUADORES%20MOTO.png" style="max-width: 100%; max-height: 120px; object-fit: contain;">
          <?php else: ?>
            <img src="img/amortiguadores.png" style="max-width: 100%; max-height: 120px; object-fit: contain;">
          <?php endif; ?>
        </div>
        
        <!-- Tabla -->
        <div style="flex: 1;">
          <!-- Headers -->
          <div class="d-flex" style="gap: 3px; margin-bottom: 4px;">
            <div class="yellow-background text-center" style="flex: 4; padding: 6px; font-size: 0.9rem; font-weight: bold;">ITEM</div>
            <div class="yellow-background text-center" style="flex: 3; padding: 6px; font-size: 0.9rem; font-weight: bold;">CONCEPTO</div>
            <div class="yellow-background text-center" style="flex: 2; padding: 6px; font-size: 0.9rem; font-weight: bold;">PORCENTAJE</div>
          </div>
          
          <!-- Filas -->
          <div class="d-flex" style="gap: 3px; margin-bottom: 3px;">
            <div class="input text-center" style="flex: 4; padding: 5px; font-size: 0.8rem;">Amortiguador anterior izquierdo</div>
            <div class="input text-center" style="flex: 3; padding: 5px; font-size: 0.8rem;"><?php echo getStateByPercent($peritaje["amortiguador_anterior_izquierdo"]); ?></div>
            <div class="input text-center" style="flex: 2; padding: 5px; font-size: 0.8rem; color: <?php echo getColorByPercent($peritaje["amortiguador_anterior_izquierdo"]); ?>; font-weight: bold;"><?php echo $peritaje["amortiguador_anterior_izquierdo"]; ?>%</div>
          </div>
          
          <div class="d-flex" style="gap: 3px; margin-bottom: 3px;">
            <div class="input text-center" style="flex: 4; padding: 5px; font-size: 0.8rem;">Amortiguador anterior derecho</div>
            <div class="input text-center" style="flex: 3; padding: 5px; font-size: 0.8rem;"><?php echo getStateByPercent($peritaje["amortiguador_anterior_derecho"]); ?></div>
            <div class="input text-center" style="flex: 2; padding: 5px; font-size: 0.8rem; color: <?php echo getColorByPercent($peritaje["amortiguador_anterior_derecho"]); ?>; font-weight: bold;"><?php echo $peritaje["amortiguador_anterior_derecho"]; ?>%</div>
          </div>
          
          <div class="d-flex" style="gap: 3px; margin-bottom: 3px;">
            <div class="input text-center" style="flex: 4; padding: 5px; font-size: 0.8rem;">Amortiguador posterior izquierdo</div>
            <div class="input text-center" style="flex: 3; padding: 5px; font-size: 0.8rem;"><?php echo getStateByPercent($peritaje["amortiguador_posterior_izquierdo"]); ?></div>
            <div class="input text-center" style="flex: 2; padding: 5px; font-size: 0.8rem; color: <?php echo getColorByPercent($peritaje["amortiguador_posterior_izquierdo"]); ?>; font-weight: bold;"><?php echo $peritaje["amortiguador_posterior_izquierdo"]; ?>%</div>
          </div>
          
          <div class="d-flex" style="gap: 3px;">
            <div class="input text-center" style="flex: 4; padding: 5px; font-size: 0.8rem;">Amortiguador posterior derecho</div>
            <div class="input text-center" style="flex: 3; padding: 5px; font-size: 0.8rem;"><?php echo getStateByPercent($peritaje["amortiguador_posterior_derecho"]); ?></div>
            <div class="input text-center" style="flex: 2; padding: 5px; font-size: 0.8rem; color: <?php echo getColorByPercent($peritaje["amortiguador_posterior_derecho"]); ?>; font-weight: bold;"><?php echo $peritaje["amortiguador_posterior_derecho"]; ?>%</div>
          </div>
        </div>
      </div>
      
      <!-- Observaciones -->
      <div style="margin-top: 15px; height: 40px; overflow-y: auto; font-size: 0.8rem;">
        <strong>OBSERVACIONES:</strong><br>
        <?php echo $peritaje["observaciones_llantas"]; ?>
      </div>
    </div>
  </div>
</section>