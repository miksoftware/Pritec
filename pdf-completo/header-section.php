<?php
// Componente: Cabecera y datos generales del peritaje
// Incluye: Datos del vehículo, datos del solicitante e inspección visual externa
?>

<section class="d-flex flex-column">
    <h4 class="text-center" style="color: blue;">SALA TÉCNICA EN AUTOMOTORES</h4>
    <h6 class="text-center mb-3" style="color: blue;">INFORME TÉCNICO</h6>
    <header class="d-flex gap-4 align-items-center mx-auto">
        <img src="img/pritec.png" style="width: 200px;object-fit: contain;"/>
        <div class="me-5" style="font-size: 1rem;">
            <p>Dirección: Carrera 16 No. 18-197 Barrio Tenerife</p>
            <p>Teléfono: 3132049245-3158928492</p>
            <p>Web: peritos.pritec.co</p>
            <p>Peritos e inspecciones técnicas vehiculares Neiva-Huila</p>
        </div>
        <div style="font-size: 1rem;">
            <p>Fecha: <?php echo $peritaje["fecha"]; ?></p>
            <p>No. Servicio: <?php echo $peritaje["no_servicio"]; ?></p>
            <p>Servicio para: <?php echo $peritaje["servicio_para"]; ?></p>
            <p>Convenio: <?php echo $peritaje["convenio"]; ?></p>
        </div>
    </header>
</section>

<section class="d-flex gap-2 rounded p-2 simple-border">
    <div class="d-flex" style="width: 33%;">
        <div class="yellow-background sub-title-vertical">
            DATOS DEL VEHÍCULO
        </div>
        <div class="d-flex flex-column gap-2 w-100" style="font-size: 1rem;">
            <div class="d-flex gap-2">
                <div class="yellow-background label">Clase</div>
                <div class="input">
                    <?php echo $peritaje["clase"]; ?>
                </div>
            </div>
            <div class="d-flex gap-2">
                <div class="yellow-background label">Marca</div>
                <div class="input">
                    <?php echo $peritaje["marca"]; ?>
                </div>
            </div>
            <div class="d-flex gap-2">
                <div class="yellow-background label">Línea</div>
                <div class="input">
                    <?php echo $peritaje["linea"]; ?>
                </div>
            </div>
            <div class="d-flex gap-2">
                <div class="yellow-background label">Cilindraje</div>
                <div class="input">
                    <?php echo $peritaje["cilindraje"]; ?>
                </div>
            </div>
            <div class="d-flex gap-2">
                <div class="yellow-background label">Kilometraje</div>
                <div class="input">
                    <?php echo $peritaje["kilometraje"]; ?>
                </div>
            </div>
            <div class="d-flex gap-2">
                <div class="yellow-background label">Servicio</div>
                <div class="input">
                    <?php echo $peritaje["servicio"]; ?>
                </div>
            </div>
            <div class="d-flex gap-2">
                <div class="yellow-background label">Modelo</div>
                <div class="input">
                    <?php echo $peritaje["modelo"]; ?>
                </div>
            </div>
            <div class="d-flex gap-2">
                <div class="yellow-background label">Color</div>
                <div class="input">
                    <?php echo $peritaje["color"]; ?>
                </div>
            </div>
            <div class="d-flex gap-2">
                <div class="yellow-background label">No. de chasis</div>
                <div class="input">
                    <?php echo $peritaje["no_chasis"]; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex" style="width: 33%;">
        <div class="d-flex flex-column gap-2 w-100" style="font-size: 1rem;">
            <div class="d-flex gap-2">
                <div class="yellow-background label">No. de motor</div>
                <div class="input">
                    <?php echo $peritaje["no_motor"]; ?>
                </div>
            </div>
            <div class="d-flex gap-2">
                <div class="yellow-background label">No. de serie</div>
                <div class="input">
                    <?php echo $peritaje["no_serie"]; ?>
                </div>
            </div>
            <div class="d-flex gap-2">
                <div class="yellow-background label">Tipo de carrocería</div>
                <div class="input">
                    <?php echo $peritaje["tipo_carroceria"]; ?>
                </div>
            </div>
            <div class="d-flex gap-2">
                <div class="yellow-background label">Organismo de <br/> tránsito</div>
                <div class="input">
                    <?php echo $peritaje["organismo_transito"]; ?>
                </div>
            </div>
            <div class="d-flex gap-2">
                <div class="yellow-background label">Código fasecolda</div>
                <div class="input">
                    <?php echo $peritaje["codigo_fasecolda"]; ?>
                </div>
            </div>
            <div class="d-flex gap-2">
                <div class="yellow-background label">Valor fasecolda</div>
                <div class="input">
                    <?php echo $peritaje["valor_fasecolda"]; ?>
                </div>
            </div>
            <div class="d-flex gap-2">
                <div class="yellow-background label">Valor sugerido</div>
                <div class="input">
                    <?php echo $peritaje["valor_sugerido"]; ?>
                </div>
            </div>
            <div class="d-flex gap-2">
                <div class="yellow-background label">Valor accesorios</div>
                <div class="input">
                    <?php echo $peritaje["valor_accesorios"]; ?>
                </div>
            </div>
            <div class="d-flex gap-2">
                <div class="yellow-background label">Resultado</div>
                <div class="input">
                    reusltado
                </div>
            </div>
        </div>
    </div>
    <div class="me-4" style="width: 33%;">
        <div class="plate"><?php echo $peritaje["placa"]; ?></div>
        <div class="yellow-background sub-title">DATOS DEL SOLICITANTE</div>
        <div class="d-flex flex-column gap-2" style="font-size: 1rem;">
            <div class="d-flex gap-2">
                <div class="yellow-background label">Nombres y <br/> apellidos</div>
                <div class="input">
                    <?php echo $peritaje["nombre_apellidos"]; ?>
                </div>
            </div>
            <div class="d-flex gap-2">
                <div class="yellow-background label">Identificación</div>
                <div class="input">
                    <?php echo $peritaje["identificacion"]; ?>
                </div>
            </div>
            <div class="d-flex gap-2">
                <div class="yellow-background label">Teléfono</div>
                <div class="input">
                    <?php echo $peritaje["telefono"]; ?>
                </div>
            </div>
            <div class="d-flex gap-2">
                <div class="yellow-background label">Dirección</div>
                <div class="input">
                    <?php echo $peritaje["direccion"]; ?>
                </div>
            </div>
            <div class="d-flex gap-2">
                <div class="yellow-background label">Correo</div>
                <div class="input">
                    <?php echo $peritaje["email"]; ?>
                </div>
            </div>
        </div>
    </div>
</section>

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
                            <div style="max-height: 170px; overflow-y: auto;" class="compact-list">
                                <?php if (!empty($estructura)): ?>
                                    <?php foreach ($estructura as $fila): ?>
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
                    OBSERVACIONES: <br/> <?php echo $peritaje["observaciones_estructura"]; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
