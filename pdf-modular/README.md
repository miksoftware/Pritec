# PDF Modular de Peritaje Completo

## Estructura del Proyecto

Este proyecto implementa una estructura modular para generar PDFs de peritaje completo, donde cada sección es independiente y fácil de mantener.

### Directorios

```
pdf-modular/
├── css/
│   └── estilos.css          # CSS unificado y fácil de manipular
├── secciones/               # Secciones independientes
│   ├── header.php           # Encabezado con logo e información
│   ├── datos-vehiculo.php   # Datos del vehículo y solicitante
│   ├── inspeccion-externa-carroceria.php
│   ├── inspeccion-externa-estructura.php
│   ├── inspeccion-interna-estructura-moto.php
│   ├── inspeccion-interna-chasis-moto.php
│   └── pie-pagina.php       # Pie de página
└── paginas/                 # Páginas que incluyen secciones
    ├── pagina-1.php         # Primera página del PDF
    ├── pagina-2.php         # (Por implementar)
    ├── pagina-3.php         # (Por implementar)
    ├── pagina-4.php         # (Por implementar)
    ├── pagina-5.php         # (Por implementar)
    └── pagina-6.php         # (Por implementar)
```

### Archivo Principal

- `peritaje-modular.php` - Archivo principal que carga los datos y arma el PDF completo

### Características de la Estructura Modular

#### 1. Secciones Independientes
- Cada sección está en un archivo PHP separado
- No hay dependencias cruzadas entre secciones
- Fácil mantenimiento y modificación individual
- Reutilización de secciones en diferentes páginas

#### 2. CSS Unificado y Limpio
- Variables CSS para colores, espaciado y tamaños
- Clases semánticas y descriptivas
- Sin conflictos de estilos entre secciones
- Fácil personalización desde un solo archivo

#### 3. Páginas Modulares
- Cada página incluye solo las secciones que necesita
- Estructura clara y mantenible
- Fácil agregar o quitar secciones de una página

#### 4. Validación de Variables
- Cada sección verifica que las variables necesarias estén disponibles
- Mensajes de error descriptivos para debugging
- Prevención de errores por variables no definidas

### Variables CSS Principales

```css
:root {
    --main-color: #fff280;        /* Color principal (amarillo) */
    --gray-color: #d8d8d8;        /* Color gris */
    --border-radius: 8px;         /* Radio de borde estándar */
    --font-size-base: 1.2rem;     /* Tamaño de fuente base */
    --spacing-large: 1rem;        /* Espaciado grande */
    /* ... más variables ... */
}
```

### Clases CSS Principales

#### Layout
- `.page` - Contenedor de página completa
- `.contenido-pagina` - Contenido principal de la página
- `.d-flex`, `.flex-column` - Utilidades de flexbox

#### Componentes
- `.fondo-amarillo` - Fondo amarillo para etiquetas
- `.placa` - Estilo para mostrar la placa del vehículo
- `.sub-titulo` - Subtítulos de secciones
- `.etiqueta` - Etiquetas de campos
- `.campo` - Campos de entrada/datos
- `.observaciones` - Área de observaciones

#### Secciones Específicas
- `.header-peritaje` - Header del documento
- `.seccion-datos` - Sección de datos del vehículo/solicitante
- `.inspeccion-visual` - Secciones de inspección visual

### Uso

1. **Para ver el PDF:**
   ```
   http://localhost/Pritec/peritaje-modular.php?id=[ID_PERITAJE]
   ```

2. **Para modificar una sección:**
   - Editar el archivo correspondiente en `pdf-modular/secciones/`
   - Los cambios se reflejan automáticamente en todas las páginas que usen esa sección

3. **Para modificar estilos:**
   - Editar `pdf-modular/css/estilos.css`
   - Usar las variables CSS para mantener consistencia

4. **Para agregar una nueva página:**
   - Crear archivo en `pdf-modular/paginas/`
   - Incluir las secciones necesarias
   - Agregar include en `peritaje-modular.php`

### Ventajas de esta Estructura

1. **Mantenibilidad:** Cada componente es independiente
2. **Reutilización:** Las secciones se pueden usar en múltiples páginas
3. **Escalabilidad:** Fácil agregar nuevas secciones o páginas
4. **CSS Limpio:** Sin conflictos de estilos, fácil personalización
5. **Debugging:** Errores localizados en secciones específicas
6. **Flexibilidad:** Fácil reorganizar el contenido de las páginas

### Próximos Pasos

1. Implementar las páginas 2-6 con sus respectivas secciones
2. Validar que el layout se vea exactamente como el original
3. Optimizar el CSS según sea necesario
4. Agregar funcionalidad de impresión/PDF si es requerida
