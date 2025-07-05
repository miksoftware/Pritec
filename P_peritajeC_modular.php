<?php
session_start();

// Verificar sesión
if (!isset($_SESSION["id_usuario"])) {
  header("Location: index.php");
  exit();
}

// Definir constante para evitar salida JSON directa
define("NO_DIRECT_JSON_OUTPUT", true);

// Validar y obtener ID
$id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
if ($id === 0) {
  $_SESSION["error"] = "ID de peritaje no válido";
  header("Location: L_peritajeC.php");
  exit();
}

require_once dirname(__FILE__) . "/peritaje_completo/Getid.php";
require_once dirname(__FILE__) . "/peritaje_completo/TipoVehiculoUrl.php";
require_once dirname(__FILE__) . "/Enums/SeguroEnum.php";
require_once dirname(__FILE__) . "/Enums/ImprontaEnum.php";

// Incluir configuración y funciones utilitarias
require_once dirname(__FILE__) . "/pdf-completo/config.php";

$conexion = new Conexion();
$conn = $conexion->conectar();

$id = $_GET["id"];
$stmt = $conn->prepare("SELECT * FROM peritaje_completo WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  $_SESSION["error"] = "Peritaje no encontrado";
  header("Location: l_peritajeC.php");
  exit();
}

$peritaje = $result->fetch_assoc();

// Cargar inspección visual externa
$stmt = $conn->prepare(
  "SELECT * FROM inspeccion_visual_carroceria WHERE peritaje_id = ?"
);
$stmt->bind_param("i", $id);
$stmt->execute();
$carroceria = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Cargar inspección visual estructura
$stmt = $conn->prepare(
  "SELECT * FROM inspeccion_visual_estructura WHERE peritaje_id = ?"
);
$stmt->bind_param("i", $id);
$stmt->execute();
$estructura = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Cargar inspección visual chasis
$stmt = $conn->prepare(
  "SELECT * FROM inspeccion_visual_chasis WHERE peritaje_id = ?"
);
$stmt->bind_param("i", $id);
$stmt->execute();
$chasis = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$conn->close();

$tipoChasis = $peritaje["tipo_chasis"];

// Configurar variables usando las funciones del config
$tiposVehiculos = getTiposVehiculos($tipoChasis);
$llantas = getLlantas($peritaje);
$amortiguadores = getAmortiguadores($peritaje);

// Configurar arrays de datos para las secciones
$tabla2 = getTabla2();
$tabla3 = getTabla3();
$campos_fugas = getCamposFugas();
$campos_estado = getCamposEstado();
$campos_nivel = getCamposNivel();

// Incluir layout vacío (igual que el original)
include "layouts/empty_header.php";
?>

<style>
  * {
    box-sizing: border-box;
  }

  html {
    font-size: 13px;
  }

  :root {
    --main-color: #fff280;
    --gray-color: #d8d8d8;
  }

  p {
    margin: 0;
  }

  .plate {
    background-color: var(--gray-color);
    border: 1px solid var(--main-color);
    text-align: center;
    width: fit-content;
    padding: 2px 1.5rem;
    border-radius: 4px;
    margin: auto;
    letter-spacing: 3px;
    font-weight: bold;
    font-size: 1.5rem;
    -webkit-text-stroke: .8px var(--main-color);
  }

  .yellow-background {
    background: var(--main-color);
    border-radius: 8px;
    text-wrap: nowrap;
    font-size: 1.3rem;
  }

  .sub-title {
    text-align: center;
    margin: 1rem auto;
    width: fit-content;
    padding: .3rem 1.5rem;
    font-size: 1.4rem;
  }

  .sub-title-vertical {
    text-align: center;
    margin: 0 1rem;
    width: fit-content;
    padding: 1.5rem .3rem;
    writing-mode: sideways-lr;
    font-size: 1.4rem;
  }

  .label {
    min-width: 50%;
    width: fit-content;
    padding: .3rem .6rem;
    align-self: center;
  }

  .input {
    width: 50%;
    padding: .2rem .5rem;
    border: 1px var(--main-color) solid;
    border-radius: 8px;
    font-size: 1rem;
  }

  .remarks {
    border: 1px solid var(--main-color);
    padding: .5rem 1rem;
    border-radius: 8px;
    height: 50px;
    font-size: .9rem;
  }

  .page {
    height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 1rem;
  }

  .simple-border {
    border: 1px solid var(--main-color)
  }

  /* Estilos específicos para optimización de espacio */
  .compact-section {
    max-height: fit-content;
  }

  .compact-image {
    max-height: 170px !important;
    object-fit: contain;
  }

  .compact-list {
    max-height: 140px;
    overflow-y: auto;
    scrollbar-width: thin;
  }

  .compact-remarks {
    height: 35px;
    overflow-y: auto;
    font-size: 0.75rem;
  }

  .small-text {
    font-size: 0.8rem;
  }

  .extra-small-text {
    font-size: 0.75rem;
  }

  /* Prevenir que las secciones se desborden a la siguiente página */
  .page-break-inside-avoid {
    page-break-inside: avoid;
    break-inside: avoid;
  }
</style>

<main class="w-100">
  <!-- Página 1: Cabecera, datos del vehículo e inspección visual -->
  <div class="page">
    <div class="d-flex flex-column gap-2">
      <?php include dirname(__FILE__) . "/pdf-completo/header-section.php"; ?>
      
      <!-- Sección: Inspección Visual Externa -->
      <?php include dirname(__FILE__) . "/pdf-completo/inspeccion-visual-externa.php"; ?>
      
      <!-- Sección: Inspección Visual Interna para motocicletas (si es necesario mostrar en página 1) -->
      <?php include dirname(__FILE__) . "/pdf-completo/inspeccion-visual-interna-motos.php"; ?>
    </div>
    
    <!-- Indicador de página 1 y texto al final -->
    <div style="position: relative; margin-top: auto;">
      <p class="text-center my-2" style="color: #777;">LA MEJOR FORMA DE COMPRAR UN CARRO USADO</p>
      <div style="position: absolute; bottom: -20px; right: 20px; font-size: 12px; color: #666;">
        Página 1
      </div>
    </div>
  </div>

  <!-- Página 2: Inspección Visual Interna (Chasis) y Llantas/Amortiguadores -->
  <div class="page d-flex flex-column justify-content-between">
    <div class="d-flex flex-column gap-2 w-100">
      
      <!-- Sección: Inspección Visual Interna (solo CHASIS para vehículos no motocicletas) -->
      <?php if (!str_contains($peritaje["tipo_vehiculo"], "MOTOCICLETA")): ?>
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
                <div class="d-flex gap-2 w-100" style="height: 220px;">
                  <?php 
                  $chasisUrl = isset($tiposVehiculos[$peritaje["tipo_vehiculo"]]) 
                      ? $tiposVehiculos[$peritaje["tipo_vehiculo"]]->urlChasis 
                      : "img/chasis/default.png";
                  ?>
                  <img src="<?php echo $chasisUrl; ?>"
                       class="w-50" style="object-fit: contain; max-height: 210px;">
                  <div class="d-flex flex-column gap-2 w-50 h-100 overflow-hidden">
                    <div class="d-flex gap-2">
                      <div class="yellow-background label text-center" style="width: 70%; padding: 0.2rem 0.5rem; font-size: 0.9rem;">Descripción pieza</div>
                      <div class="input text-center" style="padding: 0.2rem 0.5rem; font-size: 0.9rem;">Concepto</div>
                    </div>
                    <div style="max-height: 170px; overflow-y: auto;" class="compact-list">
                      <?php if (!empty($chasis)): ?>
                        <?php foreach ($chasis as $fila): ?>
                          <div class="d-flex gap-2 mb-1">
                            <div class="yellow-background label" style="width: 70%; padding: 0.2rem 0.5rem; font-size: 0.85rem;">
                              <?php echo htmlspecialchars($fila["descripcion_pieza"]); ?>
                            </div>
                            <div class="input" style="padding: 0.2rem 0.5rem; font-size: 0.85rem;"><?php echo htmlspecialchars($fila["concepto"]); ?></div>
                          </div>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>
              <div class="remarks" style="height: 50px; overflow-y: auto; font-size: 1rem;">
                OBSERVACIONES: <br/> <?php echo $peritaje["observaciones_chasis"]; ?>
              </div>
            </div>
          </div>
        </section>
      <?php endif; ?>
      
      <!-- Sección: Llantas y amortiguadores -->
      <?php include dirname(__FILE__) . "/pdf-completo/llantas-amortiguadores.php"; ?>
    </div>
    
    <!-- Indicador de página 2 y texto al final -->
    <div style="position: relative; margin-top: auto;">
      <p class="text-center my-2" style="color: #777;">LA MEJOR FORMA DE COMPRAR UN CARRO USADO</p>
      <div style="position: absolute; bottom: -20px; right: 20px; font-size: 12px; color: #666;">
        Página 2
      </div>
    </div>
  </div>

  <!-- Página 3: Batería y Scanner -->
  <div class="page">
    <?php include dirname(__FILE__) . "/pdf-completo/bateria-scanner.php"; ?>
    <div style="position: relative; margin-top: auto;">
      <p class="text-center my-2" style="color: #777;">LA MEJOR FORMA DE COMPRAR UN CARRO USADO</p>
      <div style="position: absolute; bottom: -20px; right: 20px; font-size: 12px; color: #666;">
        Página 3
      </div>
    </div>
  </div>

  <!-- Página 4: Motor -->
  <div class="page">
    <?php include dirname(__FILE__) . "/pdf-completo/motor-section.php"; ?>
    <div style="position: relative; margin-top: auto;">
      <p class="text-center my-2" style="color: #777;">LA MEJOR FORMA DE COMPRAR UN CARRO USADO</p>
      <div style="position: absolute; bottom: -20px; right: 20px; font-size: 12px; color: #666;">
        Página 4
      </div>
    </div>
  </div>

  <!-- Página 5: Interior, Fugas, Estado -->
  <div class="page">
    <?php include dirname(__FILE__) . "/pdf-completo/interior-section.php"; ?>
    <?php include dirname(__FILE__) . "/pdf-completo/fugas-section.php"; ?>
    <?php include dirname(__FILE__) . "/pdf-completo/estado-section.php"; ?>
    <?php include dirname(__FILE__) . "/pdf-completo/niveles-section.php"; ?>
    <div style="position: relative; margin-top: auto;">
      <div style="position: absolute; bottom: -20px; right: 20px; font-size: 12px; color: #666;">
        Página 5
      </div>
    </div>
  </div>

  <!-- Página 6: Fijación fotográfica y firmas -->
  <div class="page">
    <?php include dirname(__FILE__) . "/pdf-completo/fijacion-firmas.php"; ?>
    <div style="position: relative; margin-top: auto;">
      <p class="text-center my-2" style="color: #777;">LA MEJOR FORMA DE COMPRAR UN CARRO USADO</p>
      <div style="position: absolute; bottom: -20px; right: 20px; font-size: 12px; color: #666;">
        Página 6
      </div>
    </div>
  </div>

</main>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    window.print()
  })
</script>

<?php include "layouts/empty_footer.php"; ?>
