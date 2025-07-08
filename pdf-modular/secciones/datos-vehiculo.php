<?php
/**
 * Datos del Vehículo y Solicitante
 * Contiene la información del vehículo y los datos del solicitante
 */

// Verificar que $peritaje esté disponible
if (!isset($peritaje)) {
    throw new Exception("Variable \$peritaje no está disponible en la sección datos-vehiculo");
}
?>

<section class="seccion-datos">
    <!-- Columna 1: Datos del Vehículo -->
    <div class="datos-vehiculo-width">
        <div class="columna-datos">
            <div class="fondo-amarillo sub-titulo-vertical">
                DATOS DEL VEHÍCULO
            </div>
            <div class="columna-datos-contenido">
                <div class="fila-datos">
                    <div class="fondo-amarillo etiqueta">Clase</div>
                    <div class="campo">
                        <?php echo htmlspecialchars($peritaje["clase"] ?? ''); ?>
                    </div>
                </div>
                <div class="fila-datos">
                    <div class="fondo-amarillo etiqueta">Marca</div>
                    <div class="campo">
                        <?php echo htmlspecialchars($peritaje["marca"] ?? ''); ?>
                    </div>
                </div>
                <div class="fila-datos">
                    <div class="fondo-amarillo etiqueta">Línea</div>
                    <div class="campo">
                        <?php echo htmlspecialchars($peritaje["linea"] ?? ''); ?>
                    </div>
                </div>
                <div class="fila-datos">
                    <div class="fondo-amarillo etiqueta">Cilindraje</div>
                    <div class="campo">
                        <?php echo htmlspecialchars($peritaje["cilindraje"] ?? ''); ?>
                    </div>
                </div>
                <div class="fila-datos">
                    <div class="fondo-amarillo etiqueta">Servicio</div>
                    <div class="campo">
                        <?php echo htmlspecialchars($peritaje["servicio"] ?? ''); ?>
                    </div>
                </div>
                <div class="fila-datos">
                    <div class="fondo-amarillo etiqueta">Modelo</div>
                    <div class="campo">
                        <?php echo htmlspecialchars($peritaje["modelo"] ?? ''); ?>
                    </div>
                </div>
                <div class="fila-datos">
                    <div class="fondo-amarillo etiqueta">Color</div>
                    <div class="campo">
                        <?php echo htmlspecialchars($peritaje["color"] ?? ''); ?>
                    </div>
                </div>
                <div class="fila-datos">
                    <div class="fondo-amarillo etiqueta">No. Chasis</div>
                    <div class="campo">
                        <?php echo htmlspecialchars($peritaje["no_chasis"] ?? ''); ?>
                    </div>
                </div>
                <div class="fila-datos">
                    <div class="fondo-amarillo etiqueta">Combustible</div>
                    <div class="campo">
                        <?php echo htmlspecialchars($peritaje["combustible"] ?? ''); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Columna 2: Datos adicionales del vehículo -->
    <div class="datos-vehiculo-width">
        <div class="columna-datos-contenido">
            <div class="fila-datos">
                <div class="fondo-amarillo etiqueta">No. de motor</div>
                <div class="campo">
                    <?php echo htmlspecialchars($peritaje["no_motor"] ?? ''); ?>
                </div>
            </div>
            <div class="fila-datos">
                <div class="fondo-amarillo etiqueta">No. de serie</div>
                <div class="campo">
                    <?php echo htmlspecialchars($peritaje["no_serie"] ?? ''); ?>
                </div>
            </div>
            <div class="fila-datos">
                <div class="fondo-amarillo etiqueta">Tipo de carrocería</div>
                <div class="campo">
                    <?php echo htmlspecialchars($peritaje["tipo_carroceria"] ?? ''); ?>
                </div>
            </div>
            <div class="fila-datos">
                <div class="fondo-amarillo etiqueta">Organismo de tránsito</div>
                <div class="campo">
                    <?php echo htmlspecialchars($peritaje["organismo_transito"] ?? ''); ?>
                </div>
            </div>
            <div class="fila-datos">
                <div class="fondo-amarillo etiqueta">Código Fasecolda</div>
                <div class="campo">
                    <?php echo htmlspecialchars($peritaje["codigo_fasecolda"] ?? ''); ?>
                </div>
            </div>
            <div class="fila-datos">
                <div class="fondo-amarillo etiqueta">Valor sugerido</div>
                <div class="campo">
                    <?php echo htmlspecialchars($peritaje["valor_sugerido"] ?? ''); ?>
                </div>
            </div>
            <div class="fila-datos">
                <div class="fondo-amarillo etiqueta">Valor total accesorios</div>
                <div class="campo">
                    <?php echo htmlspecialchars($peritaje["valor_accesorios"] ?? ''); ?>
                </div>
            </div>
            <div class="fila-datos">
                <div class="fondo-amarillo etiqueta">Resultado</div>
                <div class="campo">
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Columna 3: Datos del Solicitante -->
    <div class="datos-solicitante-width">
        <div class="placa"><?php echo htmlspecialchars($peritaje["placa"] ?? ''); ?></div>
        <div class="fondo-amarillo sub-titulo">DATOS DEL SOLICITANTE</div>
        <div class="columna-datos-contenido">
            <div class="fila-datos">
                <div class="fondo-amarillo etiqueta">Nombres y apellidos</div>
                <div class="campo">
                    <?php echo htmlspecialchars($peritaje["nombre_apellidos"] ?? ''); ?>
                </div>
            </div>
            <div class="fila-datos">
                <div class="fondo-amarillo etiqueta">Identificación</div>
                <div class="campo">
                    <?php echo htmlspecialchars($peritaje["identificacion"] ?? ''); ?>
                </div>
            </div>
            <div class="fila-datos">
                <div class="fondo-amarillo etiqueta">Teléfono</div>
                <div class="campo">
                    <?php echo htmlspecialchars($peritaje["telefono"] ?? ''); ?>
                </div>
            </div>
            <div class="fila-datos">
                <div class="fondo-amarillo etiqueta">Dirección</div>
                <div class="campo">
                    <?php echo htmlspecialchars($peritaje["direccion"] ?? ''); ?>
                </div>
            </div>
            <div class="fila-datos">
                <div class="fondo-amarillo etiqueta">Correo Electrónico</div>
                <div class="campo">
                    <?php echo htmlspecialchars($peritaje["email"] ?? ''); ?>
                </div>
            </div>
        </div>
    </div>
</section>
