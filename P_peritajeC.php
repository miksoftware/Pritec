<?php
session_start();

// Verificar sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}

// Validar y obtener ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id === 0) {
    $_SESSION['error'] = "ID de peritaje no válido";
    header('Location: L_peritajeC.php');
    exit;
}

require_once dirname(__FILE__) . '/peritaje_completo/Getid.php';
require_once dirname(__FILE__) . '/peritaje_completo/TipoVehiculoUrl.php';
require_once dirname(__FILE__) . '/Enums/SeguroEnum.php';
require_once dirname(__FILE__) . '/Enums/ImprontaEnum.php';

$conexion = new Conexion();
$conn = $conexion->conectar();

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM peritaje_completo WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = "Peritaje no encontrado";
    header('Location: L_peritajeC.php');
    exit;
}

$peritaje = $result->fetch_assoc();

// Cargar inspección visual externa
$stmt = $conn->prepare("SELECT * FROM inspeccion_visual_carroceria WHERE peritaje_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$carroceria = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Cargar inspección visual estructura
$stmt = $conn->prepare("SELECT * FROM inspeccion_visual_estructura WHERE peritaje_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$estructura = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Cargar inspección visual chasis
$stmt = $conn->prepare("SELECT * FROM inspeccion_visual_chasis WHERE peritaje_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$chasis = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();


$conn->close();

$tipoChasis = $peritaje['tipo_chasis'];

$tiposVehiculos = [
    'COUPE - 3 PUERTAS' => new TipoVehiculoUrl(
        'img/carroceria/coupe carroceria.png',
        "img/estructura/coupe Estructura.png",
        "img/chasis/chasis predeterminado.png"
    ),
    'HATCHBACK - 5 PUERTAS' => new TipoVehiculoUrl(
        'img/carroceria/Hactback carroceria.png',
        "img/estructura/Hactback estructura.png",
        "img/estructura/chasis predeterminado.png"
    ),
    'MICROBUS' => new TipoVehiculoUrl(
        'img/carroceria/MICROBUS CARROCERIA.png',
        "img/estructura/MICROBUS estructura.png",
        "img/chasis/chasis predeterminado.png"
    ),
    'CAMIONETA WAGON- 5 PUERTAS' => new TipoVehiculoUrl(
        'img/carroceria/CAMIONETA WAGON - 5 PUERTAS carroceria.png',
        "img/estructura/CAMIONETA WAGON - 5 PUERTAS estructura.png",
        "img/chasis/chasis predeterminado.png"
    ),
    'CONVERTIBLE' => new TipoVehiculoUrl(
        'img/carroceria/convertible carroceria.png',
        "img/estructura/convertible estructura.png",
        "img/chasis/chasis predeterminado.png"
    ),
    'CAMIONETA DOBLE CABINA' => new TipoVehiculoUrl(
        'img/carroceria/Camioneta doble cabina carroceria.png',
        "img/estructura/Camioneta doble cabina estructura.png",
        "img/chasis/CAMIONETA doble cabina CHASIS camionet.png"
    ),
    'CAMIONETA CABINA SENCILLA PLATON',
    'COOPER' => new TipoVehiculoUrl(
        'img/carroceria/MINI COOPER CARROCERIA.png',
        "img/estructura/MINI COOPER ESTRUCTURA.png",
        "img/chasis/chasis predeterminado.png"
    ),
    'MULTIPROPOSITO - PASAJEROS',
    'MULTIPROPOSITOS- CARGA' => new TipoVehiculoUrl(
        'img/carroceria/CABINA MULTIPROPOSITO carga CARROCERIA.png',
        "img/estructura/CABINA MULTIPROPOSITO carga ESTRUCTURA.png",
        "img/chasis/CABINA MULTIPROPOSITO CHASIS carga.png"
    ),
    'SEDAN NOTCHBACK 4 PUERTAS' => new TipoVehiculoUrl(
        'img/carroceria/SEDAN NOTCHBACK CARROCERIA.png',
        "img/estructura/SEDAN NOTCHBACK ESTRUCTURA.png",
        "img/chasis/chasis predeterminado.png"
    ),
    'CAMPERO 3 PUERTAS',
    'AUTOMOVIL – STATION WAGON',
    'MOTOCICLETA TURISMO' => new TipoVehiculoUrl(
        'img/carroceria/Motocicleta Turismo.png',
        'img/estructura/Motocicleta Turismo.png',
        "img/chasis/$tipoChasis.png",
    ),
    'MOTOCICLETA DEPORTIVA' => new TipoVehiculoUrl(
        'img/carroceria/motocicleta deportiva.png',
        'img/estructura/motocicleta deportiva.png',
        "img/chasis/$tipoChasis.png",
    ),
    'MOTOCICLETA SCOOTER' => new TipoVehiculoUrl(
        'img/carroceria/Motocicleta scooter.png',
        'img/estructura/Motocicleta scooter.png',
        "img/chasis/$tipoChasis.png",
    ),
    'MOTOCICLETA: TIPO ENDURO' => new TipoVehiculoUrl(
        'img/carroceria/Motocicleta tipo enduro.png',
        'img/estructura/Motocicleta tipo enduro.png',
        "img/chasis/$tipoChasis.png",
    ),
    'MOTOCICLETA CUSTOM' => new TipoVehiculoUrl(
        'img/carroceria/MOTOCICLETA CUSTOM.png',
        'img/estructura/MOTOCICLETA CUSTOM.png',
        "img/chasis/$tipoChasis.png",
    ),
    'NO APLICA'
];

// Calcular promedio de porcentajes
$porcentajes = [
    $peritaje['llanta_anterior_izquierda'],
    $peritaje['llanta_anterior_derecha'],
    $peritaje['llanta_posterior_izquierda'],
    $peritaje['llanta_posterior_derecha'],
    $peritaje['amortiguador_anterior_izquierdo'],
    $peritaje['amortiguador_anterior_derecho'],
    $peritaje['amortiguador_posterior_izquierdo'],
    $peritaje['amortiguador_posterior_derecho'],
];

function getStateByPercent(int $percent) : string
{
    if ($percent >= 0 && $percent <= 24){
        return 'Peligroso';
    } elseif ($percent >= 25 && $percent <= 49){
        return 'Precaución';
    } elseif ($percent >= 50 && $percent <= 74){
        return 'Seguro';
    } elseif ($percent >= 75 && $percent <= 100){
        return 'Nuevo/a';
    }

    return '';
}

$tabla2 = [
    'estado_arranque' => 'Arranque',
    'respuesta_arranque' => '',
    'estado_radiador' => 'Radiador',
    'respuesta_radiador' => '',
    'estado_carter_motor' => 'Cárter Motor',
    'respuesta_carter_motor' => '',
    'estado_carter_caja' => 'Cárter Caja',
    'respuesta_carter_caja' => '',
    'estado_caja_velocidades' => 'Caja de Velocidades',
    'respuesta_caja_velocidades' => '',
    'estado_soporte_caja' => 'Soporte Caja',
    'estado_soporte_motor' => 'Soporte Motor',
    'respuesta_soporte_caja' => '',
    'respuesta_soporte_motor' => '',
    'estado_mangueras_radiador' => 'Mangueras Radiador',
    'respuesta_mangueras_radiador' => '',
    'estado_correas' => 'Correas',
    'respuesta_correas' => '',
    'tension_correas' => 'Tensión Correas',
    'respuesta_tension_correas' => '',
    'estado_filtro_aire' => 'Filtro de Aire',
    'respuesta_filtro_aire' => '',
    'estado_externo_bateria' => 'Externo Batería',
    'respuesta_externo_bateria' => '',
    'estado_pastilla_freno' => 'Pastilla de Freno',
    'respuesta_pastilla_freno' => '',
    'estado_discos_freno' => 'Discos de Freno',
    'respuesta_discos_freno' => '',
    'estado_punta_eje' => 'Punta de Eje',
    'respuesta_punta_eje' => '',
    'estado_axiales' => 'Axiales',
    'respuesta_axiales' => '',
    'estado_terminales' => 'Terminales',
    'respuesta_terminales' => '',
    'estado_rotulas' => 'Rótulas',
    'respuesta_rotulas' => '',
    'estado_tijeras' => 'Tijeras',
    'respuesta_tijeras' => '',
    'estado_caja_direccion' => 'Caja de Dirección',
    'respuesta_caja_direccion' => '',
    'estado_rodamientos' => 'Rodamientos',
    'respuesta_rodamientos' => '',
    'estado_cardan' => 'Cardán',
    'respuesta_cardan' => '',
    'estado_crucetas' => 'Crucetas'
];

$tabla3 = [
    'estado_calefaccion' => 'Calefacción',
    'respuesta_calefaccion' => '',
    'estado_aire_acondicionado' => 'Aire Acondicionado',
    'respuesta_aire_acondicionado' => '',
    'estado_cinturones' => 'Cinturones',
    'respuesta_cinturones' => '',
    'estado_tapiceria_asientos' => 'Tapicería Asientos',
    'respuesta_tapiceria_asientos' => '',
    'estado_tapiceria_techo' => 'Tapicería Techo',
    'respuesta_tapiceria_techo' => '',
    'estado_millaret' => 'Millaret',
    'respuesta_millaret' => '',
    'estado_alfombra' => 'Alfombra',
    'respuesta_alfombra' => '',
    'estado_chapas' => 'Chapas',
    'respuesta_chapas' => ''
];

$campos_fugas = [
    'respuesta_fuga_aceite_motor' => 'Fuga Aceite Motor',
    'respuesta_fuga_aceite_caja_velocidades' => 'Fuga Aceite Caja Velocidades',
    'respuesta_fuga_aceite_caja_transmision' => 'Fuga Aceite Caja Transmisión',
    'respuesta_fuga_liquido_frenos' => 'Fuga Líquido Frenos',
    'respuesta_fuga_aceite_direccion_hidraulica' => 'Fuga Aceite Dirección Hidráulica',
    'respuesta_fuga_liquido_bomba_embrague' => 'Fuga Líquido Bomba Embrague',
    'respuesta_fuga_tanque_combustible' => 'Fuga Tanque Combustible'
];

$campos_estado = [
    'respuesta_estado_tanque_silenciador' => 'Estado Tanque Silenciador',
    'respuesta_estado_tubo_exhosto' => 'Estado Tubo Exhosto',
    'respuesta_estado_tanque_catalizador_gases' => 'Estado Catalizador Gases',
    'respuesta_estado_guardapolvo_caja_direccion' => 'Estado Guardapolvo Caja Dirección',
    'respuesta_estado_tuberia_frenos' => 'Estado Tubería Frenos',
    'respuesta_viscosidad_aceite_motor' => 'Viscosidad Aceite Motor'
];

$campos_nivel = [
    'respuesta_viscosidad_aceite_motor' => 'Viscosidad aceite motor',
    'respuesta_nivel_refrigerante_motor' => 'Nivel Refrigerante Motor',
    'respuesta_nivel_liquido_frenos' => 'Nivel Líquido Frenos',
    'respuesta_nivel_agua_limpiavidrios' => 'Nivel Agua Limpiavidrios',
    'respuesta_nivel_aceite_direccion_hidraulica' => 'Nivel Aceite Dirección Hidráulica',
    'respuesta_nivel_liquido_embrague' => 'Nivel Líquido Embrague',
    'respuesta_nivel_aceite_motor' => 'Nivel Aceite Motor'
];

include 'layouts/empty_header.php';
?>

    <style>
        * {
            box-sizing: border-box;
        }

        html {
            font-size: 12px;
        }

        :root {
            --main-color: #fff280;
            --gray-color: #d8d8d8;
        }

        @media print {
            body {
                background: url('img/background.png') repeat-y center center;
                background-size: contain;
            }
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
            font-size: 1.2rem;
        }

        .sub-title {
            text-align: center;
            margin: 1rem auto;
            width: fit-content;
            padding: .2rem 1.5rem;
        }

        .sub-title-vertical {
            text-align: center;
            margin: 0 1rem;
            width: fit-content;
            padding: 1.5rem .2rem;
            writing-mode: sideways-lr;
        }

        .label {
            width: 50%;
            padding: .2rem .5rem;
            align-self: center;
        }

        .input {
            width: 50%;
            padding: .2rem .5rem;
            border: 1px var(--main-color) solid;
            border-radius: 8px;
        }

        .remarks {
            border: 1px solid var(--main-color);
            padding: .5rem 1rem;
            border-radius: 8px;
            height: 50px;
            font-size: .8rem
        }
    </style>

    <main class="w-100 m-4">
        <h4 class="text-center">SALA TÉCNICA EN AUTOMOTORES</h4>
        <h6 class="text-center mb-3">CERIFICACIÓN TÉCNICA EN IDENTIFICACIÓN DE AUTOMOTORES</h6>
        <header class="d-flex gap-4 mb-4 align-items-center mx-auto">
            <img src="img/pritec.png" style="width: 150px;object-fit: contain;"/>
            <div class="me-5">
                <p>Dirección: Carrera 16 No. 18-197 Barrio Tenerife</p>
                <p>Teléfono: 3132049245-3158928492</p>
                <p>Web: peritos.pritec.co</p>
                <p>Peritos e inspecciones técnicas vehiculares Neiva-Huila</p>
            </div>
            <div>
                <p>Fecha: <?php echo $peritaje['fecha'] ?></p>
                <p>No. Servicio: <?php echo $peritaje['no_servicio'] ?></p>
                <p>Servicio para: <?php echo $peritaje['servicio_para'] ?></p>
                <p>Convenio: <?php echo $peritaje['convenio'] ?></p>
            </div>
        </header>
        <section class="d-flex gap-2 my-4">
            <div class="w-50 d-flex">
                <div class="yellow-background sub-title-vertical">
                    DATOS DEL VEHÍCULO
                </div>
                <div class="d-flex flex-column gap-2 w-100">
                    <div class="d-flex gap-2">
                        <div class="yellow-background label">Clase</div>
                        <div class="input">
                            <?php echo $peritaje['clase'] ?>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="yellow-background label">Marca</div>
                        <div class="input">
                            <?php echo $peritaje['marca'] ?>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="yellow-background label">Línea</div>
                        <div class="input">
                            <?php echo $peritaje['linea'] ?>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="yellow-background label">Cilindraje</div>
                        <div class="input">
                            <?php echo $peritaje['cilindraje'] ?>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="yellow-background label">Servicio</div>
                        <div class="input">
                            <?php echo $peritaje['servicio'] ?>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="yellow-background label">Modelo</div>
                        <div class="input">
                            <?php echo $peritaje['modelo'] ?>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="yellow-background label">Color</div>
                        <div class="input">
                            <?php echo $peritaje['color'] ?>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="yellow-background label">No. de chasis</div>
                        <div class="input">
                            <?php echo $peritaje['no_chasis'] ?>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="yellow-background label">No. de motor</div>
                        <div class="input">
                            <?php echo $peritaje['no_motor'] ?>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="yellow-background label">No. de serie</div>
                        <div class="input">
                            <?php echo $peritaje['no_serie'] ?>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="yellow-background label">Tipo de carrocería</div>
                        <div class="input">
                            <?php echo $peritaje['tipo_carroceria'] ?>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="yellow-background label">Organismo de tránsito</div>
                        <div class="input">
                            <?php echo $peritaje['organismo_transito'] ?>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="yellow-background label">Kilometraje</div>
                        <div class="input">
                            <?php echo $peritaje['kilometraje'] ?>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="yellow-background label">Código fasecolda</div>
                        <div class="input">
                            <?php echo $peritaje['codigo_fasecolda'] ?>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="yellow-background label">Valor fasecolda</div>
                        <div class="input">
                            <?php echo $peritaje['valor_fasecolda'] ?>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="yellow-background label">Valor sugerido</div>
                        <div class="input">
                            <?php echo $peritaje['valor_sugerido'] ?>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="yellow-background label">Valor accesorios</div>
                        <div class="input">
                            <?php echo $peritaje['valor_accesorios'] ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-50 me-4">
                <div class="plate"><?php echo $peritaje['placa'] ?></div>
                <div class="yellow-background sub-title">DATOS DEL SOLICITANTE</div>
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex gap-2">
                        <div class="yellow-background label">Nombres y apellidos</div>
                        <div class="input">
                            <?php echo $peritaje['nombre_apellidos'] ?>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="yellow-background label">Identificación</div>
                        <div class="input">
                            <?php echo $peritaje['identificacion'] ?>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="yellow-background label">Teléfono</div>
                        <div class="input">
                            <?php echo $peritaje['telefono'] ?>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="yellow-background label">Dirección</div>
                        <div class="input">
                            <?php echo $peritaje['direccion'] ?>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <div class="yellow-background label">Correo</div>
                        <div class="input">
                            <?php echo $peritaje['email'] ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php if (!str_contains($peritaje['tipo_vehiculo'], "MOTOCICLETA")): ?>
            <section class="p-2 rounded my-4" style="border: 1px solid var(--main-color)">
                <div class="d-flex gap-2">
                    <div class="yellow-background sub-title-vertical">INSPECCIÓN VISUAL EXTERNA</div>
                    <div class="d-flex flex-column w-100">
                        <div class="yellow-background sub-title w-100">
                            VEHÍCULO: <?php echo $peritaje['tipo_vehiculo'] ?> </div>
                        <p>Indique con un círculo en que parte del vehículo tiene alguna condición.</p>
                        <div class="yellow-background sub-title ms-4 mb-0">CARROCERÍA</div>
                        <div class="d-flex gap-2 w-100">
                            <img src="<?php echo $tiposVehiculos[$peritaje['tipo_vehiculo']]->urlCarroceria ?>"
                                 class="w-50"
                                 style="object-fit: contain;">
                            <div class="d-flex flex-column gap-2 w-50 h-100">
                                <div class="d-flex gap-2">
                                    <div class="yellow-background label text-center" style="width: 70%">Descripción
                                        pieza
                                    </div>
                                    <div class="input text-center">
                                        Concepto
                                    </div>
                                </div>
                                <?php if (!empty($carroceria)): ?>
                                    <?php foreach ($carroceria as $fila): ?>
                                        <div class="d-flex gap-2">
                                            <div class="yellow-background label" style="width: 70%">
                                                <?php echo htmlspecialchars($fila['descripcion_pieza']); ?>
                                            </div>
                                            <div class="input"><?php echo htmlspecialchars($fila['concepto']); ?></div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="remarks">
                            OBSERVACIONES: <br/> <?php echo htmlspecialchars($peritaje['observaciones_inspeccion']) ?>
                        </div>
                    </div>
                </div>
            </section>
            <p class="text-center my-4" style="color: #777;">LA MEJOR FORMA DE COMPRAR UN CARRO USADO</p>
            }
        <?php endif; ?>
        <section class="p-2 rounded my-4" style="border: 1px solid var(--main-color)">
            <div class="d-flex gap-2">
                <div class="yellow-background sub-title-vertical">INSPECCIÓN VISUAL EXTERNA</div>
                <div class="d-flex flex-column w-100">
                    <?php if (str_contains($peritaje['tipo_vehiculo'], "MOTOCICLETA")): ?>
                        <div class="yellow-background sub-title w-100">
                            VEHÍCULO: <?php echo $peritaje['tipo_vehiculo'] ?> </div>
                    <?php endif; ?>
                    <p>Indique con un círculo en que parte del vehículo tiene alguna condición.</p>
                    <div>
                        <div class="yellow-background sub-title ms-4 mb-0">ESTRUCTURA</div>
                        <div class="d-flex gap-2 w-100">
                            <img src="<?php echo $tiposVehiculos[$peritaje['tipo_vehiculo']]->urlEstructura ?>"
                                 class="w-50" height="200" style="object-fit: contain;">
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
                                                <?php echo htmlspecialchars($fila['descripcion_pieza']); ?>
                                            </div>
                                            <div class="input"><?php echo htmlspecialchars($fila['concepto']); ?></div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="yellow-background sub-title ms-4 mb-0">CHASIS</div>
                        <div class="d-flex gap-2 w-100">
                            <img src="<?php echo $tiposVehiculos[$peritaje['tipo_vehiculo']]->urlChasis ?>" class="w-50"
                                 height="200" style="object-fit: contain;">
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
                                                <?php echo htmlspecialchars($fila['descripcion_pieza']); ?>
                                            </div>
                                            <div class="input"><?php echo htmlspecialchars($fila['concepto']); ?></div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="remarks" style="height: fit-content">
                        OBSERVACIONES: <br/> <?php echo $peritaje['observaciones_estructura'] ?>
                    </div>
                </div>
            </div>
        </section>
        <section class="p-2 rounded my-4" style="border: 1px solid var(--main-color)">
            <div class="d-flex gap-2">
                <div class="yellow-background sub-title-vertical">LLANTAS Y AMORTIGUADORES</div>
                <div class="d-flex flex-column w-100">
                    <div class="d-flex gap-2 w-100">
                        <div class="d-flex flex-column gap-3" style="width: 30%">
                            <div class="yellow-background label text-center w-100">LLANTAS</div>
                            <?php if (str_contains($peritaje['tipo_vehiculo'], "MOTOCICLETA")): ?>
                                <img src="img/LLANTAS%20MOTO.png" style="object-fit: contain">
                            <?php else: ?>
                                <img src="img/llantas.png" style="object-fit: contain;width: 30%;">
                            <?php endif ?>
                        </div>
                        <div class="d-flex flex-column gap-2 h-100" style="width: 70%;">
                            <div class="d-flex gap-2">
                                <div class="yellow-background label text-center">Ítem</div>
                                <div class="yellow-background label text-center">Concepto</div>
                                <div class="yellow-background label text-center">Porcentaje</div>
                            </div>
                            <div class="d-flex gap-2">
                                <div class="input text-center">Llanta anterior izquierda</div>
                                <div class="input text-center">
                                    <?php echo getStateByPercent($peritaje['llanta_anterior_izquierda']) ?>
                                </div>
                                <div class="input text-center">
                                    <?php echo $peritaje['llanta_anterior_izquierda'] ?>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <div class="input text-center">Llanta anterior derecha</div>
                                <div class="input text-center">
                                    <?php echo getStateByPercent($peritaje['llanta_anterior_derecha']) ?>
                                </div>
                                <div class="input text-center">
                                    <?php echo $peritaje['llanta_anterior_derecha'] ?>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <div class="input text-center">Llanta posterior izquierda</div>
                                <div class="input text-center">
                                    <?php echo getStateByPercent($peritaje['llanta_posterior_izquierda']) ?>
                                </div>
                                <div class="input text-center">
                                    <?php echo $peritaje['llanta_posterior_izquierda'] ?>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <div class="input text-center">Llanta posterior derecha</div>
                                <div class="input text-center">
                                    <?php echo getStateByPercent($peritaje['llanta_posterior_izquierda']) ?>
                                </div>
                                <div class="input text-center">
                                    <?php echo $peritaje['llanta_posterior_derecha'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2 w-100">
                        <div class="d-flex flex-column gap-3" style="width: 30%">
                            <div class="yellow-background label text-center w-100">AMORTIGUADORES</div>
                            <?php if (str_contains($peritaje['tipo_vehiculo'], "MOTOCICLETA")): ?>
                                <img src="img/AMORTIGUADORES%20MOTO.png" style="object-fit: contain">
                            <?php else: ?>
                                <img src="img/amortiguadores.png" style="object-fit: contain;width: 30%;">
                            <?php endif ?>
                        </div>
                        <div class="d-flex flex-column gap-2 h-100" style="width: 70%;">
                            <div class="d-flex gap-2">
                                <div class="yellow-background label text-center">Ítem</div>
                                <div class="yellow-background label text-center">Concepto</div>
                                <div class="yellow-background label text-center">Porcentaje</div>
                            </div>
                            <div class="d-flex gap-2">
                                <div class="input text-center">Amortiguador anterior izquierdo
                                </div>
                                <div class="input text-center">
                                    <?php echo getStateByPercent($peritaje['amortiguador_anterior_izquierdo']) ?>
                                </div>
                                <div class="input text-center">
                                    <?php echo $peritaje['amortiguador_anterior_izquierdo'] ?>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <div class="input text-center">Amortiguador anterior derecho
                                </div>
                                <div class="input text-center">
                                    <?php echo getStateByPercent($peritaje['amortiguador_anterior_derecho']) ?>
                                </div>
                                <div class="input text-center">
                                    <?php echo $peritaje['amortiguador_anterior_derecho'] ?>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <div class="input text-center">Amortiguador posterior izquierdo
                                </div>
                                <div class="input text-center">
                                    <?php echo getStateByPercent($peritaje['amortiguador_posterior_izquierdo']) ?>
                                </div>
                                <div class="input text-center">
                                    <?php echo $peritaje['amortiguador_posterior_izquierdo'] ?>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <div class="input text-center">Amortiguador posterior derecho
                                </div>
                                <div class="input text-center">
                                    <?php echo getStateByPercent($peritaje['amortiguador_posterior_izquierdo']) ?>
                                </div>
                                <div class="input text-center">
                                    <?php echo $peritaje['amortiguador_posterior_derecho'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="remarks" style="height: fit-content">
                        OBSERVACIONES: <br> <?php echo $peritaje['observaciones_llantas'] ?>
                    </div>
                </div>
            </div>
        </section>
        <section class="p-2 rounded my-4" style="border: 1px solid var(--main-color)">
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
                                <div class="input text-center">Prueba de batería</div>
                                <div class="input text-center">
                                    <?php echo getStateByPercent($peritaje['prueba_bateria']) ?>
                                </div>
                                <div class="input text-center">
                                    <?php echo $peritaje['prueba_bateria'] ?>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <div class="input text-center">Prueba de arranque</div>
                                <div class="input text-center">
                                    <?php echo getStateByPercent($peritaje['prueba_arranque']) ?>
                                </div>
                                <div class="input text-center">
                                    <?php echo $peritaje['prueba_arranque'] ?>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <div class="input text-center">Carga de bateria</div>
                                <div class="input text-center">
                                    <?php echo getStateByPercent($peritaje['carga_bateria']) ?>
                                </div>
                                <div class="input text-center">
                                    <?php echo $peritaje['carga_bateria'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="p-2 rounded my-4" style="border: 1px solid var(--main-color)">
            <div class="d-flex flex-column gap-2">
                <div class="yellow-background sub-title w-100">PRUEBA DE OBSERVACIÓN Y DIAGNÓSTICO SCANNER</div>
                <div class="d-flex flex-column w-100">
                    <p>El scanner automotriz es una herramienta que se utiliza para diagnosticar las fallas registradas
                        en la computadora del vehículo. La computadora se encarga de regular las funciones del auto
                        a través de distintos sensores que monitorean y registran todos los errores con un código:</p>
                    <?php echo $peritaje['prueba_escaner'] ?>
                </div>
            </div>
        </section>
        <p class="text-center my-4" style="color: #777;">LA MEJOR FORMA DE COMPRAR UN CARRO USADO</p>
        <section class="p-2 rounded my-4" style="border: 1px solid var(--main-color)">
            <div class="d-flex flex-column gap-2 w-100 mb-3">
            <div class="yellow-background sub-title w-100">MOTOR</div>
                <div class="d-flex flex-column gap-2 w-100 h-100">
                    <div class="d-flex gap-2">
                        <div class="yellow-background label" style="width: 25%;">SISTEMA</div>
                        <div class="input text-center" style="width: 25%">
                            ESTADO
                        </div>
                        <div class="input text-center" style="width: 50%">
                            RESPUESTA
                        </div>
                    </div>
                    <?php foreach ($tabla2 as $campo => $etiqueta): ?>
                        <?php if (strpos($campo, 'estado_') !== false): ?>
                            <div class="d-flex gap-2">
                                <div class="yellow-background label" style="width: 25%;">
                                    <?= $etiqueta ?>
                                </div>
                                <div class="input text-center" style="width: 25%">
                                    <?= $peritaje[$campo] ?>
                                </div>
                                <div class="input text-center" style="width: 50%">
                                    <?= $peritaje[str_replace('estado_', 'respuesta_', $campo)] ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="remarks" style="height: fit-content">
                OBSERVACIONES: <br> <?php echo $peritaje['observaciones_motor'] ?>
            </div>
        </section>
        <p class="text-center my-4" style="color: #777;">LA MEJOR FORMA DE COMPRAR UN CARRO USADO</p>        <section class="p-2 rounded my-4" style="border: 1px solid var(--main-color)">
        <section class="p-2 rounded my-4" style="border: 1px solid var(--main-color)">
            <div class="d-flex flex-column gap-2 w-100 mb-3">
            <div class="yellow-background sub-title w-100">INTERIOR DEL AUTOMOTOR</div>
                <div class="d-flex flex-column gap-2 w-100 h-100">
                    <div class="d-flex gap-2">
                        <div class="yellow-background label" style="width: 25%;">SISTEMA</div>
                        <div class="input text-center" style="width: 25%">
                            ESTADO
                        </div>
                        <div class="input text-center" style="width: 50%">
                            RESPUESTA
                        </div>
                    </div>
                    <?php foreach ($tabla3 as $campo => $etiqueta): ?>
                        <?php if (strpos($campo, 'estado_') !== false): ?>
                            <div class="d-flex gap-2">
                                <div class="yellow-background label" style="width: 25%;">
                                    <?= $etiqueta ?>
                                </div>
                                <div class="input text-center" style="width: 25%">
                                    <?= $peritaje[$campo] ?>
                                </div>
                                <div class="input text-center" style="width: 50%">
                                    <?= $peritaje[str_replace('estado_', 'respuesta_', $campo)] ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="remarks" style="height: fit-content">
                OBSERVACIONES: <br> <?php echo $peritaje['observaciones_interior'] ?>
            </div>
        </section>
        <section class="p-2 rounded my-4" style="border: 1px solid var(--main-color)">
            <div class="d-flex flex-column gap-2 w-100 mb-3">
                <div class="yellow-background sub-title w-100">FUGAS</div>
                <div class="d-flex flex-column gap-2 w-100 h-100">
                    <div class="d-flex gap-2">
                        <div class="yellow-background label" style="width: 50%;">SISTEMA</div>
                        <div class="input text-center" style="width: 50%">
                            ESTADO
                        </div>
                    </div>
                    <?php foreach ($campos_fugas as $campo => $etiqueta): ?>
                        <div class="d-flex gap-2">
                            <div class="yellow-background label" style="width: 50%;">
                                <?= $etiqueta ?>
                            </div>
                            <div class="input text-center" style="width: 50%">
                                <?= $peritaje[$campo] ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="remarks" style="height: fit-content">
                OBSERVACIONES: <br> <?php echo $peritaje['observaciones_fugas'] ?>
            </div>
        </section>
        <section class="p-2 rounded my-4" style="border: 1px solid var(--main-color)">
            <div class="d-flex flex-column gap-2 w-100 mb-3">
                <div class="d-flex flex-column gap-2 w-100 h-100">
                    <div class="d-flex gap-2">
                        <div class="yellow-background label" style="width: 50%;">SISTEMA</div>
                        <div class="input text-center" style="width: 50%">
                            ESTADO
                        </div>
                    </div>
                    <?php foreach ($campos_estado as $campo => $etiqueta): ?>
                        <div class="d-flex gap-2">
                            <div class="yellow-background label" style="width: 50%;">
                                <?= $etiqueta ?>
                            </div>
                            <div class="input text-center" style="width: 50%">
                                <?= $peritaje[$campo] ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <section class="p-2 rounded my-4" style="border: 1px solid var(--main-color)">
            <div class="d-flex flex-column gap-2 w-100 mb-3">
                <div class="d-flex flex-column gap-2 w-100 h-100">
                    <div class="d-flex gap-2">
                        <div class="yellow-background label" style="width: 50%;">SISTEMA</div>
                        <div class="input text-center" style="width: 50%">
                            ESTADO
                        </div>
                    </div>
                    <?php foreach ($campos_nivel as $campo => $etiqueta): ?>
                        <div class="d-flex gap-2">
                            <div class="yellow-background label" style="width: 50%;">
                                <?= $etiqueta ?>
                            </div>
                            <div class="input text-center" style="width: 50%">
                                <?= $peritaje[$campo] ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="remarks" style="height: fit-content">
                PRUEBA DE RUTA: <br> <?php echo $peritaje['prueba_ruta'] ?>
            </div>
        </section>
        <section>
            <div class="d-flex gap-2">
                <div class="yellow-background sub-title-vertical">FIJACIÓN FOTOGRÁFICA</div>
                <div class="d-flex flex-column w-100">
                    <p>Observación y clasificación de las características del automotor de acuerdo al punto 1</p>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); grid-template-rows: repeat(2, 1fr); gap: 8px;">
                        <?php
                        for ($i = 0; $i < 6; $i++) {
                            $name = 'fijacion_fotografica_' . $i + 1;
                            $url = $peritaje[$name];
                            if ($url) {
                                echo '<div style="border: 1px solid var(--main-color);border-radius: 8px;padding: 5px">	
                                    <img src="uploads/' . $url . '" style="object-fit: contain; width: 100%">
                                </div>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>
        <p class="text-center my-4" style="color: #777;">
            LA MEJOR FORMA DE COMPRAR UN CARRO USADO</p>
        <div class="d-flex justify-content-between my-4" style="gap: 40px">
            <div>
                <p class="mb-3">Firma Inspector estructura vehicular:</p>
                <p>______________________________________</p>
                <p>CC:</p>
            </div>
            <div>
                <p class="mb-3">Firma cliente:</p>
                <p>______________________________________</p>
                <p>CC:</p>
            </div>
        </div>
        <div class="d-flex justify-content-center my-4" style="gap: 40px">
            <div>
                <p class="mb-3">Firma Inspector estructura vehicular:</p>
                <p>______________________________________</p>
                <p>CC:</p>
            </div>
        </div>

        <small style="font-size: 10px; font-weight: bold; margin-top: 1rem">
            AVISO LEGAL: Pritec Informa que la revisión realizada corresponde al estado del vehículo en la fecha y hora
            de la misma y con el recorrido del
            kilometraje que revela el odómetro en el momento, se advierte que, debido a la vulnerabilidad a que se ven
            expuestos este tipo de bienes, en
            cuanto a la afectación, modificación, avería, deterioro y desgaste de cualquiera de sus componentes, el
            informe que se pone de presente no
            garantiza de ningún modo que el estado del vehiculo sea el mismo en fechas posteriores a la fecha de la
            revisión.
        </small>


        <p class="text-center my-4" style="color: #777;">LA MEJOR FORMA DE COMPRAR UN CARRO USADO</p>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            window.print()
        })
    </script>

<?php include 'layouts/empty_footer.php'; ?>