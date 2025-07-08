# Guía de Testing - PDF Modular

## URLs de Prueba

### Para vehículos normales (no motocicletas):
```
http://localhost/Pritec/peritaje-modular.php?id=1
```

### Para motocicletas:
```
http://localhost/Pritec/peritaje-modular.php?id=[ID_DE_MOTOCICLETA]
```

### Para auto-imprimir:
```
http://localhost/Pritec/peritaje-modular.php?id=1&print=true
```

## Estado Actual del PDF

### ✅ Página 1 - COMPLETADA
- Header con información de la empresa
- Datos del vehículo y solicitante
- Inspección Visual Externa - Carrocería
- Inspección Visual Externa - Estructura
- Inspección Visual Interna - Estructura (motocicletas)
- Inspección Visual Interna - Chasis (motocicletas)

### ✅ Página 2 - COMPLETADA
- Inspección Visual Interna - Chasis (vehículos normales)

### ⏳ Páginas Pendientes
- Página 3: Por implementar
- Página 4: Por implementar  
- Página 5: Por implementar
- Página 6: Por implementar

## Cambios Implementados

### ✅ 1. Pie de página corregido
- Ahora solo aparece al final de cada página completa
- No se muestra en páginas intermedias
- Usa la clase `.pie-pagina` con `margin-top: auto`

### ✅ 2. Numeración en inspecciones visuales
- **Conceptos**: Ahora muestran formato "Regular - (6)"
- **Descripciones**: Muestran formato "COSTADO IZQUIERDO - (6)"
- **Aplica para**: Carrocería, Estructura y Chasis
- **Funciona en**: Inspecciones externas e internas

### ✅ 3. Campos de datos corregidos
- Corregidos nombres de campos de base de datos:
  - `numero_motor` → `no_motor`
  - `numero_chasis` → `no_chasis`
  - `numero_serie` → `no_serie`
- Ya no aparecen campos vacíos innecesarios

### ✅ 4. Funciones helper
- Archivo `pdf-modular/helpers/funciones.php`
- Funciones para formateo automático con numeración
- Arrays de conceptos y descripciones centralizados

### ✅ 5. Inspección Visual Interna - Chasis (Página 2)
- Nueva sección de inspección interna para chasis
- Array de descripciones específicas para piezas de chasis:
  - LARGUERO IZQUIERDO, LARGUERO DERECHO
  - TRAVESAÑOS (DELANTERO, CENTRAL, TRASERO)
  - SOPORTES (MOTOR, TRANSMISIÓN, SUSPENSIÓN)
  - PUNTOS DE ANCLAJE
- Imagen dinámica según tipo de vehículo
- Solo se muestra para vehículos que no sean motocicletas

## Funcionalidades

### Condicionales inteligentes
- **Vehículos normales**: Muestran inspección externa (carrocería + estructura)
- **Motocicletas**: Muestran inspección interna (estructura + chasis)

### CSS modular
- Variables CSS para fácil personalización
- Sin conflictos entre secciones
- Clases semánticas y descriptivas

### Numeración automática
- Los conceptos se numeran automáticamente según su posición en el array
- Las descripciones de piezas mantienen su numeración original
- Formato consistente: "Texto - (Número)"

## Estructura de archivos mantenida

```
pdf-modular/
├── css/estilos.css                           # Estilos unificados
├── helpers/funciones.php                     # Funciones de formateo
├── secciones/                                # Secciones modulares
│   ├── header.php
│   ├── datos-vehiculo.php
│   ├── inspeccion-externa-carroceria.php
│   ├── inspeccion-externa-estructura.php
│   ├── inspeccion-interna-estructura-moto.php
│   ├── inspeccion-interna-chasis-moto.php
│   └── pie-pagina.php
└── paginas/
    └── pagina-1.php                          # Página completa
```

## Próximos pasos sugeridos

1. **Validar visualmente** que la numeración se vea correcta
2. **Probar con motocicletas** para verificar que muestre las secciones correctas
3. **Continuar con páginas 2-6** cuando esta página esté perfecta
4. **Ajustar CSS** si hay algún detalle visual que mejorar
