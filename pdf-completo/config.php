<?php
/**
 * Archivo de configuración y utilidades para el sistema de peritajes
 * Contiene funciones comunes y configuraciones globales
 */

// Función para obtener el estado basado en porcentaje
function getStateByPercent(?int $percent): string
{
  if ($percent >= 0 && $percent <= 24) {
    return "Peligroso";
  } elseif ($percent >= 25 && $percent <= 49) {
    return "Precaución";
  } elseif ($percent >= 50 && $percent <= 74) {
    return "Seguro";
  } elseif ($percent >= 75 && $percent <= 100) {
    return "Nuevo/a";
  }

  return "";
}

// Función para obtener el color basado en porcentaje
function getColorByPercent(?int $percent): string
{
  if ($percent >= 0 && $percent <= 24) {
    return "#ff0000"; // Rojo
  } elseif ($percent >= 25 && $percent <= 49) {
    return "#ff8000"; // Naranja
  } elseif ($percent >= 50 && $percent <= 74) {
    return "#ffff00"; // Amarillo
  } elseif ($percent >= 75 && $percent <= 100) {
    return "#00ff00"; // Verde
  }

  return "#000000"; // Negro por defecto
}

// Configuración de tipos de vehículos
function getTiposVehiculos($tipoChasis = ""): array
{
  return [
    "COUPE - 3 PUERTAS" => new TipoVehiculoUrl(
      "img/carroceria/coupe carroceria.png",
      "img/estructura/coupe Estructura.png",
      "img/chasis/chasis predeterminado.png"
    ),
    "SEDAN NOTCHBACK 4 PUERTAS" => new TipoVehiculoUrl(
      "img/carroceria/sedan notchback 4 puertas carroceria.png",
      "img/estructura/sedan notchback 4 puertas estructura.png",
      "img/chasis/chasis predeterminado.png"
    ),
    "HATCHBACK - 5 PUERTAS" => new TipoVehiculoUrl(
      "img/carroceria/Hactback carroceria.png",
      "img/estructura/Hactback estructura.png",
      "img/chasis/chasis predeterminado.png"
    ),
    "MICROBUS" => new TipoVehiculoUrl(
      "img/carroceria/MICROBUS CARROCERIA.png",
      "img/estructura/MICROBUS estructura.png",
      "img/chasis/chasis predeterminado.png"
    ),
    "CAMIONETA WAGON- 5 PUERTAS" => new TipoVehiculoUrl(
      "img/carroceria/CAMIONETA WAGON - 5 PUERTAS carroceria.png",
      "img/estructura/CAMIONETA WAGON - 5 PUERTAS estructura.png",
      "img/chasis/chasis predeterminado.png"
    ),
    "CONVERTIBLE" => new TipoVehiculoUrl(
      "img/carroceria/convertible carroceria.png",
      "img/estructura/convertible estructura.png",
      "img/chasis/chasis predeterminado.png"
    ),
    "CAMIONETA DOBLE CABINA" => new TipoVehiculoUrl(
      "img/carroceria/Camioneta doble cabina carroceria.png",
      "img/estructura/Camioneta doble cabina estructura.png",
      "img/chasis/CAMIONETA doble cabina CHASIS camionet.png"
    ),
    "COOPER" => new TipoVehiculoUrl(
      "img/carroceria/MINI COOPER CARROCERIA.png",
      "img/estructura/MINI COOPER ESTRUCTURA.png",
      "img/chasis/chasis predeterminado.png"
    ),
    "MULTIPROPOSITOS- CARGA" => new TipoVehiculoUrl(
      "img/carroceria/CABINA MULTIPROPOSITO carga CARROCERIA.png",
      "img/estructura/CABINA MULTIPROPOSITO carga ESTRUCTURA.png",
      "img/chasis/CABINA MULTIPROPOSITO CHASIS carga.png"
    ),
    "MOTOCICLETA TURISMO" => new TipoVehiculoUrl(
      "img/carroceria/Motocicleta Turismo.png",
      "img/estructura/Motocicleta Turismo.png",
      "img/chasis/{$tipoChasis}.png"
    ),
    "MOTOCICLETA DEPORTIVA" => new TipoVehiculoUrl(
      "img/carroceria/motocicleta deportiva.png",
      "img/estructura/motocicleta deportiva.png",
      "img/chasis/{$tipoChasis}.png"
    ),
    "MOTOCICLETA SCOOTER" => new TipoVehiculoUrl(
      "img/carroceria/Motocicleta scooter.png",
      "img/estructura/Motocicleta scooter.png",
      "img/chasis/{$tipoChasis}.png"
    ),
    "MOTOCICLETA: TIPO ENDURO" => new TipoVehiculoUrl(
      "img/carroceria/Motocicleta tipo enduro.png",
      "img/estructura/Motocicleta tipo enduro.png",
      "img/chasis/{$tipoChasis}.png"
    ),
    "MOTOCICLETA CUSTOM" => new TipoVehiculoUrl(
      "img/carroceria/MOTOCICLETA CUSTOM.png",
      "img/estructura/MOTOCICLETA CUSTOM.png",
      "img/chasis/{$tipoChasis}.png"
    ),
  ];
}

// Función para obtener arreglos de llantas
function getLlantas($peritaje): array
{
  return [
    $peritaje["llanta_anterior_izquierda"],
    $peritaje["llanta_anterior_derecha"],
    $peritaje["llanta_posterior_izquierda"],
    $peritaje["llanta_posterior_derecha"],
  ];
}

// Función para obtener arreglos de amortiguadores
function getAmortiguadores($peritaje): array
{
  return [
    $peritaje["amortiguador_anterior_izquierdo"],
    $peritaje["amortiguador_anterior_derecho"],
    $peritaje["amortiguador_posterior_izquierdo"],
    $peritaje["amortiguador_posterior_derecho"],
  ];
}

// Función para validar si es motocicleta
function esMotocicleta($tipoVehiculo): bool
{
  return str_contains($tipoVehiculo, "MOTOCICLETA") || 
         str_contains($tipoVehiculo, "MOTO");
}

// Función para formatear datos de manera segura
function formatearDato($dato): string
{
  return htmlspecialchars($dato ?? '');
}

// Función para obtener tablas de campos
function getTabla2(): array
{
  return [
    "estado_arranque" => "Arranque",
    "respuesta_arranque" => "",
    "estado_radiador" => "Radiador",
    "respuesta_radiador" => "",
    "estado_carter_motor" => "Cárter Motor",
    "respuesta_carter_motor" => "",
    "estado_carter_caja" => "Cárter Caja",
    "respuesta_carter_caja" => "",
    "estado_caja_velocidades" => "Caja de Velocidades",
    "respuesta_caja_velocidades" => "",
    "estado_soporte_caja" => "Soporte Caja",
    "estado_soporte_motor" => "Soporte Motor",
    "respuesta_soporte_caja" => "",
    "respuesta_soporte_motor" => "",
    "estado_mangueras_radiador" => "Mangueras Radiador",
    "respuesta_mangueras_radiador" => "",
    "estado_correas" => "Correas",
    "respuesta_correas" => "",
    "tension_correas" => "Tensión Correas",
    "respuesta_tension_correas" => "",
    "estado_filtro_aire" => "Filtro de Aire",
    "respuesta_filtro_aire" => "",
    "estado_externo_bateria" => "Externo Batería",
    "respuesta_externo_bateria" => "",
    "estado_pastilla_freno" => "Pastilla de Freno",
    "respuesta_pastilla_freno" => "",
    "estado_discos_freno" => "Discos de Freno",
    "respuesta_discos_freno" => "",
    "estado_punta_eje" => "Punta de Eje",
    "respuesta_punta_eje" => "",
    "estado_axiales" => "Axiales",
    "respuesta_axiales" => "",
    "estado_terminales" => "Terminales",
    "respuesta_terminales" => "",
    "estado_rotulas" => "Rótulas",
    "respuesta_rotulas" => "",
    "estado_tijeras" => "Tijeras",
    "respuesta_tijeras" => "",
    "estado_caja_direccion" => "Caja de Dirección",
    "respuesta_caja_direccion" => "",
    "estado_rodamientos" => "Rodamientos",
    "respuesta_rodamientos" => "",
    "estado_cardan" => "Cardán",
    "respuesta_cardan" => "",
    "estado_crucetas" => "Crucetas",
  ];
}

function getTabla3(): array
{
  return [
    "estado_calefaccion" => "Calefacción",
    "respuesta_calefaccion" => "",
    "estado_aire_acondicionado" => "Aire Acondicionado",
    "respuesta_aire_acondicionado" => "",
    "estado_cinturones" => "Cinturones",
    "respuesta_cinturones" => "",
    "estado_tapiceria_asientos" => "Tapicería Asientos",
    "respuesta_tapiceria_asientos" => "",
    "estado_tapiceria_techo" => "Tapicería Techo",
    "respuesta_tapiceria_techo" => "",
    "estado_millaret" => "Millaret",
    "respuesta_millaret" => "",
    "estado_alfombra" => "Alfombra",
    "respuesta_alfombra" => "",
    "estado_chapas" => "Chapas",
    "respuesta_chapas" => "",
  ];
}

function getCamposFugas(): array
{
  return [
    "respuesta_fuga_aceite_motor" => "Fuga Aceite Motor",
    "respuesta_fuga_aceite_caja_velocidades" => "Fuga Aceite Caja Velocidades",
    "respuesta_fuga_aceite_caja_transmision" => "Fuga Aceite Caja Transmisión",
    "respuesta_fuga_liquido_frenos" => "Fuga Líquido Frenos",
    "respuesta_fuga_aceite_direccion_hidraulica" =>
    "Fuga Aceite Dirección Hidráulica",
    "respuesta_fuga_liquido_bomba_embrague" => "Fuga Líquido Bomba Embrague",
    "respuesta_fuga_tanque_combustible" => "Fuga Tanque Combustible",
  ];
}

function getCamposEstado(): array
{
  return [
    "respuesta_estado_tanque_silenciador" => "Estado Tanque Silenciador",
    "respuesta_estado_tubo_exhosto" => "Estado Tubo Exhosto",
    "respuesta_estado_tanque_catalizador_gases" => "Estado Catalizador Gases",
    "respuesta_estado_guardapolvo_caja_direccion" =>
    "Estado Guardapolvo Caja Dirección",
    "respuesta_estado_tuberia_frenos" => "Estado Tubería Frenos",
    "respuesta_viscosidad_aceite_motor" => "Viscosidad Aceite Motor",
  ];
}

function getCamposNivel(): array
{
  return [
    "respuesta_viscosidad_aceite_motor" => "Viscosidad aceite motor",
    "respuesta_nivel_refrigerante_motor" => "Nivel Refrigerante Motor",
    "respuesta_nivel_liquido_frenos" => "Nivel Líquido Frenos",
    "respuesta_nivel_agua_limpiavidrios" => "Nivel Agua Limpiavidrios",
    "respuesta_nivel_aceite_direccion_hidraulica" =>
    "Nivel Aceite Dirección Hidráulica",
    "respuesta_nivel_liquido_embrague" => "Nivel Líquido Embrague",
    "respuesta_nivel_aceite_motor" => "Nivel Aceite Motor",
  ];
}

?>
