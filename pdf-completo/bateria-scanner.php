<?php
// Componente: Batería
// Incluye: Sección de actuación de la batería
?>

<!-- CONVENCIONES BATERÍA -->
<section class="p-2 rounded my-2" style="border: 1px solid var(--main-color)">
  <div class="yellow-background sub-title text-center">CONVENCIONES BATERÍA</div>
  
  <!-- Barra de porcentaje -->
  <div class="d-flex align-items-center my-3">
    <span style="font-size: 0.9rem; width: 40px;">0%</span>
    <div class="flex-grow-1 mx-2" style="height: 20px; border: 1px solid #000; display: flex;">
      <div style="background: #ff0000; width: 25%; height: 100%;"></div>
      <div style="background: #ff8000; width: 25%; height: 100%;"></div>
      <div style="background: #ffff00; width: 25%; height: 100%;"></div>
      <div style="background: #00ff00; width: 25%; height: 100%;"></div>
    </div>
    <span style="font-size: 0.9rem; width: 45px; text-align: right;">100%</span>
  </div>
  
  <!-- Leyenda debajo de la barra -->
  <div class="d-flex justify-content-between" style="font-size: 0.75rem;">
    <div class="d-flex align-items-center" style="width: 23%;">
      <div style="width: 12px; height: 12px; background: #ff0000; margin-right: 4px;"></div>
      <span>0-24% Peligroso: Batería descargada</span>
    </div>
    <div class="d-flex align-items-center" style="width: 23%;">
      <div style="width: 12px; height: 12px; background: #ff8000; margin-right: 4px;"></div>
      <span>25-49% Precaución: Carga baja</span>
    </div>
    <div class="d-flex align-items-center" style="width: 23%;">
      <div style="width: 12px; height: 12px; background: #ffff00; margin-right: 4px;"></div>
      <span>50-74% Seguir: Carga moderada</span>
    </div>
    <div class="d-flex align-items-center" style="width: 23%;">
      <div style="width: 12px; height: 12px; background: #00ff00; margin-right: 4px;"></div>
      <span>75-100% Normal: Buen estado</span>
    </div>
  </div>
</section>

<div class="page">
  <section class="p-2 rounded my-2" style="border: 1px solid var(--main-color)">
    <div class="d-flex gap-2">
      <div class="yellow-background sub-title-vertical">ACTUACIÓN DE LA BATERIA</div>
      <div class="d-flex flex-column w-100">
        <div class="d-flex gap-2 w-100">
          <div class="d-flex flex-column gap-3" style="width: 30%">
            <div class="yellow-background label text-center w-100">BATERÍA</div>
            <img src="img/BATERIA.png" style="object-fit: contain">
          </div>
          <div class="d-flex flex-column gap-2 h-100" style="width: 70%;">
            <div class="d-flex gap-2">
              <div class="yellow-background label text-center">Ítem</div>
              <div class="yellow-background label text-center">Concepto</div>
              <div class="yellow-background label text-center">Porcentaje</div>
            </div>
            <div class="d-flex gap-2">
              <div class="input text-center">Carga de batería</div>
              <div class="input text-center">
                <?php echo getStateByPercent($peritaje["carga_bateria"]); ?>
              </div>
              <div class="input text-center" style="color: <?php echo getColorByPercent($peritaje["carga_bateria"]); ?>; font-weight: bold;">
                <?php echo $peritaje["carga_bateria"]; ?>%
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  
  <section class="p-2 rounded my-2" style="border: 1px solid var(--main-color)">
    <div class="d-flex flex-column gap-2">
      <div class="yellow-background sub-title w-100">PRUEBA DE OBSERVACIÓN Y DIAGNÓSTICO SCANNER</div>
      <div class="d-flex flex-column w-100">
        <p>El scanner automotriz es una herramienta que se utiliza para diagnosticar las fallas registradas
          en la computadora del vehículo. La computadora se encarga de regular las funciones del auto
          a través de distintos sensores que monitorean y registran todos los errores con un código:</p>
        <?php echo $peritaje["prueba_escaner"]; ?>
      </div>
    </div>
  </section>
</div>
