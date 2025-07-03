class TestDataGenerator {
    constructor() {
        this.nombres = [
            'Juan Carlos Pérez', 'María Elena García', 'Luis Fernando Rodríguez',
            'Ana Isabel Martínez', 'Carlos Alberto López', 'Patricia Morales',
            'José Miguel Hernández', 'Laura Patricia Díaz', 'Roberto Carlos Silva',
            'Carmen Rosa González'
        ];
        
        this.identificaciones = [
            '12345678', '87654321', '11223344', '55667788', '99887766',
            '44332211', '66778899', '33445566', '77889900', '22334455'
        ];
        
        this.telefonos = [
            '3001234567', '3019876543', '3051122334', '3134455667',
            '3207788990', '3116677889', '3023344556', '3158899001'
        ];
        
        this.direcciones = [
            'Calle 123 #45-67', 'Carrera 89 #12-34', 'Avenida 56 #78-90',
            'Diagonal 23 #44-55', 'Transversal 67 #89-01', 'Calle 34 Sur #23-45'
        ];
        
        this.emails = [
            'test1@email.com', 'test2@email.com', 'test3@email.com',
            'prueba1@correo.com', 'prueba2@correo.com', 'demo@test.com'
        ];
        
        this.placas = [
            'ABC123', 'DEF456', 'GHI789', 'JKL012', 'MNO345',
            'PQR678', 'STU901', 'VWX234', 'YZA567', 'BCD890'
        ];
        
        this.marcas = [
            'Toyota', 'Chevrolet', 'Renault', 'Nissan', 'Hyundai',
            'Kia', 'Ford', 'Volkswagen', 'Mazda', 'Honda'
        ];
        
        this.lineas = [
            'Corolla', 'Aveo', 'Logan', 'Versa', 'i10',
            'Picanto', 'Fiesta', 'Gol', 'Mazda2', 'Civic'
        ];
        
        this.colores = [
            'Blanco', 'Negro', 'Gris', 'Rojo', 'Azul',
            'Plata', 'Dorado', 'Verde', 'Amarillo', 'Beige'
        ];
        
        this.servicios = [
            'Particular', 'Público', 'Oficial', 'Diplomático', 'Escolar'
        ];
        
        this.clases = [
            'Automóvil', 'Camioneta', 'Motocicleta', 'Bus', 'Camión'
        ];

        // Datos para chasis - descripción de piezas comunes
        this.descripcionesPiezasChasis = [
            'Larguero derecho',
            'Larguero izquierdo',
            'Travesaño delantero',
            'Travesaño trasero',
            'Soporte motor delantero',
            'Soporte motor trasero',
            'Marco inferior',
            'Puntos de anclaje'
        ];
    }
    
    getRandomItem(array) {
        return array[Math.floor(Math.random() * array.length)];
    }
    
    getRandomNumber(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }
    
    getRandomDate() {
        const start = new Date();
        start.setDate(start.getDate() - 30); // 30 días atrás
        const end = new Date();
        const date = new Date(start.getTime() + Math.random() * (end.getTime() - start.getTime()));
        return date.toISOString().split('T')[0];
    }
    
    generateTestData() {
        return {
            // Servicio
            fecha: this.getRandomDate(),
            no_servicio: 'SRV-' + this.getRandomNumber(1000, 9999),
            servicio_para: this.getRandomItem(['Seguros Bolívar', 'Seguros SURA', 'Mapfre', 'Liberty', 'AXA']),
            convenio: this.getRandomItem(['Conv-001', 'Conv-002', 'Conv-003', '']),
            
            // Solicitante
            nombre_apellidos: this.getRandomItem(this.nombres),
            identificacion: this.getRandomItem(this.identificaciones),
            telefono: this.getRandomItem(this.telefonos),
            direccion: this.getRandomItem(this.direcciones),
            email: this.getRandomItem(this.emails),
            
            // Vehículo
            placa: this.getRandomItem(this.placas),
            clase: this.getRandomItem(this.clases),
            marca: this.getRandomItem(this.marcas),
            linea: this.getRandomItem(this.lineas),
            cilindraje: this.getRandomNumber(1000, 3000).toString(),
            servicio: this.getRandomItem(this.servicios),
            modelo: this.getRandomNumber(2010, 2024).toString(),
            color: this.getRandomItem(this.colores),
            no_chasis: 'CH' + this.getRandomNumber(100000, 999999),
            no_motor: 'MT' + this.getRandomNumber(100000, 999999),
            no_serie: 'SR' + this.getRandomNumber(100000, 999999),
            tipo_carroceria: this.getRandomItem(['Sedan', 'Hatchback', 'SUV', 'Pickup']),
            organismo_transito: this.getRandomItem(['Tránsito Municipal', 'Secretaría de Movilidad']),
            kilometraje: this.getRandomNumber(10000, 200000),
            codigo_fasecolda: this.getRandomNumber(100000, 999999).toString(),
            valor_fasecolda: this.getRandomNumber(20000000, 80000000),
            valor_sugerido: this.getRandomNumber(18000000, 75000000),
            valor_accesorios: this.getRandomNumber(500000, 5000000),
            
            // Llantas
            llanta_anterior_izquierda: this.getRandomNumber(50, 100),
            llanta_anterior_derecha: this.getRandomNumber(50, 100),
            llanta_posterior_izquierda: this.getRandomNumber(50, 100),
            llanta_posterior_derecha: this.getRandomNumber(50, 100),
            observaciones_llantas: 'Observaciones de prueba para llantas',
            
            // Amortiguadores
            amortiguador_anterior_izquierdo: this.getRandomNumber(60, 100),
            amortiguador_anterior_derecho: this.getRandomNumber(60, 100),
            amortiguador_posterior_izquierdo: this.getRandomNumber(60, 100),
            amortiguador_posterior_derecho: this.getRandomNumber(60, 100),
            observaciones_amortiguadores: 'Observaciones de prueba para amortiguadores',
            
            // Scanner
            prueba_escaner: 'P' + this.getRandomNumber(1000, 9999),
            observaciones_escaner: 'Sin códigos de error detectados',
            
            // Batería
            prueba_bateria: this.getRandomNumber(70, 100),
            prueba_arranque: this.getRandomNumber(70, 100),
            carga_bateria: this.getRandomNumber(70, 100),
            observaciones_bateria: 'Batería en buen estado',
            
            // Observaciones generales
            observaciones_inspeccion: 'Observaciones de prueba para inspección visual',
            observaciones_estructura: 'Observaciones de prueba para estructura',
            observaciones_chasis: 'Observaciones de prueba para chasis',
            observaciones_motor: 'Motor en buen estado general',
            observaciones_interior: 'Interior en condiciones aceptables',
            observaciones_fugas: 'No se detectaron fugas significativas',
            prueba_ruta: 'Vehículo responde adecuadamente en prueba de ruta'
        };
    }
    
    fillForm() {
        const testData = this.generateTestData();
        
        // Llenar campos de texto e inputs
        Object.keys(testData).forEach(key => {
            const element = document.querySelector(`[name="${key}"]`);
            if (element) {
                if (element.type === 'checkbox') {
                    element.checked = Math.random() > 0.5;
                } else {
                    element.value = testData[key];
                }
            }
        });
        
        // Seleccionar tipo de vehículo aleatoriamente
        this.selectRandomVehicleType();
        
        // Llenar sistemas del motor aleatoriamente
        this.fillRandomSystemStates();
        
        // Llenar fugas aleatoriamente
        this.fillRandomLeaks();
        
        console.log('Formulario llenado con datos de prueba');
    }
    
    selectRandomVehicleType() {
        const tiposVehiculos = [
            'COUPE - 3 PUERTAS',
            'HATCHBACK - 5 PUERTAS',
            'SEDAN NOTCHBACK 4 PUERTAS',
            'AUTOMOVIL – STATION WAGON',
            'MOTOCICLETA TURISMO'
        ];
        
        const tipoSeleccionado = this.getRandomItem(tiposVehiculos);
        
        // Simular click en el tipo de vehículo
        setTimeout(() => {
            const displayEl = document.getElementById('tipo_vehiculo_display');
            const inputEl = document.getElementById('tipo_vehiculo_input');
            
            if (displayEl && inputEl) {
                displayEl.value = tipoSeleccionado;
                inputEl.value = tipoSeleccionado;
                
                // Simular el evento de selección de tipo de vehículo
                const items = document.querySelectorAll('.tipo-vehiculo-item');
                items.forEach(item => {
                    if (item.textContent.trim() === tipoSeleccionado) {
                        item.click();
                    }
                });
            }
        }, 500);
    }
    
    fillRandomSystemStates() {
        const estados = ['BUENO', 'REGULAR', 'MALO'];
        const sistemasMotor = [
            'estado_arranque', 'estado_radiador', 'estado_carter_motor',
            'estado_carter_caja', 'estado_caja_velocidades', 'estado_soporte_caja',
            'estado_soporte_motor', 'estado_mangueras_radiador', 'estado_correas',
            'tension_correas', 'estado_filtro_aire', 'estado_externo_bateria',
            'estado_pastilla_freno', 'estado_discos_freno', 'estado_punta_eje',
            'estado_axiales', 'estado_terminales', 'estado_rotulas',
            'estado_tijeras', 'estado_caja_direccion', 'estado_rodamientos',
            'estado_cardan', 'estado_crucetas', 'estado_calefaccion',
            'estado_aire_acondicionado', 'estado_cinturones', 'estado_tapiceria_asientos',
            'estado_tapiceria_techo', 'estado_millaret', 'estado_alfombra', 'estado_chapas'
        ];
        
        sistemasMotor.forEach(sistema => {
            const select = document.querySelector(`[name="${sistema}"]`);
            if (select) {
                const estadoAleatorio = this.getRandomItem(estados);
                select.value = estadoAleatorio;
            }
            
            // Llenar respuesta correspondiente
            const respuesta = sistema.replace('estado_', 'respuesta_').replace('tension_', 'respuesta_tension_');
            const inputRespuesta = document.querySelector(`[name="${respuesta}"]`);
            if (inputRespuesta) {
                inputRespuesta.value = 'Observación de prueba para ' + sistema;
            }
        });
    }
    
    fillRandomLeaks() {
        const fugasYNiveles = [
            'respuesta_fuga_aceite_motor',
            'respuesta_fuga_aceite_caja_velocidades',
            'respuesta_fuga_aceite_caja_transmision',
            'respuesta_fuga_liquido_frenos',
            'respuesta_fuga_aceite_direccion_hidraulica',
            'respuesta_fuga_liquido_bomba_embrague',
            'respuesta_fuga_tanque_combustible',
            'respuesta_estado_tanque_silenciador',
            'respuesta_estado_tubo_exhosto',
            'respuesta_estado_tanque_catalizador_gases',
            'respuesta_estado_guardapolvo_caja_direccion',
            'respuesta_estado_tuberia_frenos',
            'respuesta_viscosidad_aceite_motor',
            'respuesta_nivel_refrigerante_motor',
            'respuesta_nivel_liquido_frenos',
            'respuesta_nivel_agua_limpiavidrios',
            'respuesta_nivel_aceite_direccion_hidraulica',
            'respuesta_nivel_liquido_embrague',
            'respuesta_nivel_aceite_motor'
        ];
        
        fugasYNiveles.forEach(fuga => {
            const input = document.querySelector(`[name="${fuga}"]`);
            if (input) {
                const observaciones = [
                    'Normal', 'Sin novedades', 'En buen estado',
                    'Nivel óptimo', 'Sin fugas detectadas', 'Funcionamiento correcto'
                ];
                input.value = this.getRandomItem(observaciones);
            }
        });
    }
    
    fillInspectionTables() {
        // Llenar tabla de inspección visual (carrocería) con múltiples filas
        this.fillInspectionTableWithMultipleRows('tablaInspeccionVisual', 'descripcion_pieza', 'concepto_pieza', 'agregarFilaInspeccion', 'eliminar-fila');
        
        // Llenar tabla de estructura con múltiples filas
        this.fillInspectionTableWithMultipleRows('tablaInspeccionEstructura', 'descripcion_pieza_estructura', 'concepto_pieza_estructura', 'agregarFilaEstructura', 'eliminar-fila-estructura');
        
        // Llenar tabla de chasis con múltiples filas y tipo de chasis
        this.fillChasisTable();
    }
    
    fillInspectionTableWithMultipleRows(tableId, descripcionName, conceptoName, addButtonId, deleteButtonClass) {
        const table = document.getElementById(tableId);
        if (!table) return;
        
        // Agregar 2-4 filas adicionales
        const additionalRows = this.getRandomNumber(2, 4);
        for (let i = 0; i < additionalRows; i++) {
            const addButton = document.getElementById(addButtonId);
            if (addButton) {
                addButton.click();
            }
        }
        
        // Esperar un poco y luego llenar todas las filas
        setTimeout(() => {
            const selects = table.querySelectorAll(`select[name="${descripcionName}[]"]`);
            const conceptSelects = table.querySelectorAll(`select[name="${conceptoName}[]"]`);
            
            selects.forEach((select, index) => {
                // Seleccionar opción aleatoria (excluyendo la primera que es placeholder)
                if (select.options.length > 1) {
                    const randomIndex = this.getRandomNumber(1, select.options.length - 1);
                    select.selectedIndex = randomIndex;
                }
            });
            
            conceptSelects.forEach((select, index) => {
                // Seleccionar concepto aleatorio
                if (select.options.length > 1) {
                    const randomIndex = this.getRandomNumber(1, select.options.length - 1);
                    select.selectedIndex = randomIndex;
                }
            });
        }, 200);
    }
    
    fillChasisTable() {
        const table = document.getElementById('tablaInspeccionChasis');
        if (!table) return;
        
        // Primero llenar el tipo de chasis si existe
        const tipoChasisSelect = document.getElementById('tipo_chasis');
        if (tipoChasisSelect && tipoChasisSelect.options.length > 1) {
            // Seleccionar "APLICA" si está disponible, sino una opción aleatoria que no sea "NO APLICA"
            let selectedIndex = 0;
            for (let i = 1; i < tipoChasisSelect.options.length; i++) {
                if (tipoChasisSelect.options[i].value === 'APLICA') {
                    selectedIndex = i;
                    break;
                } else if (tipoChasisSelect.options[i].value !== 'NO APLICA' && selectedIndex === 0) {
                    selectedIndex = i;
                }
            }
            
            if (selectedIndex > 0) {
                tipoChasisSelect.selectedIndex = selectedIndex;
                // Disparar evento change para mostrar/ocultar elementos
                const event = new Event('change');
                tipoChasisSelect.dispatchEvent(event);
            }
        }
        
        // Esperar un poco para que se procese el evento de cambio del tipo de chasis
        setTimeout(() => {
            // Verificar si la tabla está visible (no oculta por "NO APLICA")
            const tablaContainer = table.closest('.table-responsive');
            if (tablaContainer && !tablaContainer.classList.contains('d-none')) {
                // Agregar 2-3 filas adicionales
                const additionalRows = this.getRandomNumber(2, 3);
                for (let i = 0; i < additionalRows; i++) {
                    const addButton = document.getElementById('agregarFilaChasis');
                    if (addButton) {
                        addButton.click();
                    }
                }
                
                // Llenar las descripciones de piezas y conceptos
                setTimeout(() => {
                    const descripcionInputs = table.querySelectorAll('input[name="descripcion_pieza_chasis[]"]');
                    const conceptSelects = table.querySelectorAll('select[name="concepto_pieza_chasis[]"]');
                    
                    descripcionInputs.forEach((input, index) => {
                        input.value = this.getRandomItem(this.descripcionesPiezasChasis);
                    });
                    
                    conceptSelects.forEach((select, index) => {
                        // Seleccionar concepto aleatorio
                        if (select.options.length > 1) {
                            const randomIndex = this.getRandomNumber(1, select.options.length - 1);
                            select.selectedIndex = randomIndex;
                        }
                    });
                }, 300);
            }
        }, 500);
    }
}

// Función global para usar desde la consola
window.testDataGenerator = new TestDataGenerator();
window.fillTestData = () => {
    window.testDataGenerator.fillForm();
    setTimeout(() => {
        window.testDataGenerator.fillInspectionTables();
    }, 1500); // Aumentar el tiempo para permitir que se procesen todos los eventos
};