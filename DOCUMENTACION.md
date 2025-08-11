# Plugin Resales Online API Connector
## Guía Completa de Instalación y Funcionamiento

### 📋 **Índice**
1. [Descripción General](#descripción-general)
2. [Arquitectura del Plugin](#arquitectura-del-plugin)
3. [Sistema Inteligente Demo/Producción](#sistema-inteligente-demoproducción)
4. [Integración con Elementor](#integración-con-elementor)
5. [Shortcodes Disponibles](#shortcodes-disponibles)
6. [Instalación](#instalación)
7. [Configuración](#configuración)
8. [Uso Práctico](#uso-práctico)
9. [Solución de Problemas](#solución-de-problemas)

---

## **Descripción General**

El **Plugin Resales Online API Connector** es una solución completa para integrar la API V6 de Resales Online con WordPress, diseñado específicamente para **Lusso Mediterráneo**. Permite mostrar propiedades inmobiliarias reales con un diseño elegante y funcionalidad completa.

### ✨ **Características Principales**
- **Integración automática** con formularios existentes de Elementor
- **Sistema dual**: Datos demo en desarrollo, API real en producción
- **Diseño responsive** optimizado para móviles
- **Estética coherente** con la marca Lusso Mediterráneo
- **Búsqueda avanzada** con filtros múltiples
- **Carga rápida** y optimización SEO

---

## **Arquitectura del Plugin**

### 📁 **Estructura de Archivos**
```
wp-content/plugins/resales-online-connector/
├── resales-online-connector.php    # Plugin principal
├── elementor-integration.php       # Integración con Elementor
├── demo-data.php                   # Datos de demostración
├── assets/
│   ├── style.css                   # Estilos CSS optimizados
│   └── script.js                   # JavaScript para interactividad
└── templates/
    ├── search-form.php             # Formulario de búsqueda
    └── properties-grid.php         # Grid de propiedades
```

### 🔧 **Componentes Técnicos**

#### **1. Plugin Principal (`resales-online-connector.php`)**
- Gestión de la API de Resales Online V6
- Sistema de shortcodes
- Panel de administración
- Detección automática de entorno

#### **2. Integración Elementor (`elementor-integration.php`)**
- Detección automática de formularios existentes
- Conversión de enlaces en botones funcionales
- Extracción inteligente de valores de campos
- Renderizado de resultados

#### **3. Datos Demo (`demo-data.php`)**
- 6 propiedades realistas de la Costa del Sol
- Datos estructurados compatibles con API real
- Filtros funcionales para desarrollo

---

## **Sistema Inteligente Demo/Producción**

### ⚙️ **Funcionamiento Automático**

```php
public function fetch_properties($params = array()) {
    // 1. Detecta automáticamente el entorno
    if ($this->is_localhost()) {
        return $this->get_demo_data($params);  // Datos demo en desarrollo
    } else {
        // 2. API real en producción
        return $this->call_resales_api($params);
    }
}
```

### 🔄 **Flujos de Trabajo**

#### **Modo Desarrollo (Localhost)**
1. Usuario visita página → Shortcode detectado
2. Plugin verifica entorno → Detecta localhost
3. Carga datos demo → 6 propiedades realistas
4. Aplica filtros → Según parámetros del shortcode
5. Renderiza template → Muestra propiedades con estilo Lusso

#### **Modo Producción (Servidor Real)**
1. Usuario visita página → Shortcode detectado
2. Plugin verifica entorno → Detecta servidor producción
3. Llama API Resales → Con credenciales reales
4. Procesa respuesta → JSON con propiedades reales
5. Renderiza template → Propiedades de tu agencia

### 🎯 **API de Resales Online V6**
- **URL**: `https://webapi.resales-online.com/V6/SearchProperties`
- **Método**: GET con parámetros
- **Autenticación**: IP autorizada + API Key
- **Filtros**: Por agencia, tipo, precio, ubicación, dormitorios

### 🏷️ **Filtros Predefinidos**
```php
private $malaga_filters = array(
    'ventas' => 1,           // FilterAgencyId :1
    'alquiler_corto' => 2,   // FilterAgencyId :2  
    'alquiler_largo' => 3,   // FilterAgencyId :3
    'destacados' => 4        // FilterAgencyId :4
);
```

---

## **Integración con Elementor**

### 🎨 **¿Por qué es Importante?**
La integración con Elementor permite que **tu formulario actual** (el que ya tienes diseñado) se vuelva **100% funcional** sin necesidad de recrearlo.

### 🔍 **Detección Automática**
El plugin detecta automáticamente:
- Botones con texto "BUSCAR"
- Campos de entrada con placeholder "Málaga, Marbella..."
- Selects con opciones como "Villa", "Apartamento", etc.
- Campos de precio con símbolos "€"

### ⚡ **JavaScript Inteligente**
```javascript
// 1. Encuentra tu botón BUSCAR actual
const searchButton = $('a[href*="BUSCAR"], button:contains("BUSCAR")');

// 2. Le añade funcionalidad real
searchButton.off('click').on('click', function(e) {
    e.preventDefault();
    handleElementorSearch(); // Función que maneja la búsqueda
});

// 3. Extrae valores de tus campos actuales
function getElementorFormValues() {
    // Busca campos por placeholder "Málaga, Marbella..."
    const locationField = $('input[placeholder*="Málaga"]');
    
    // Identifica selects por sus opciones y les asigna función
    // (Villa, Apartamento, etc.)
}
```

### 🎬 **Experiencia de Usuario**
1. **Usuario llena formulario** → Mismo diseño que ya tienes
2. **Hace clic en "BUSCAR"** → Botón se convierte en funcional
3. **Aparece "Buscando..."** → Loading visual atractivo
4. **Resultados aparecen debajo** → Grid de propiedades elegante
5. **Notificación de éxito** → "Se encontraron X propiedades"

---

## **Shortcodes Disponibles**

### 1. **[resales_search_form]** - Formulario de Búsqueda
```html
<!-- Formulario básico -->
[resales_search_form]
```
**Genera**: Formulario completo con todos los campos optimizados y validados.

### 2. **[resales_properties]** - Grid de Propiedades
```html
<!-- Propiedades básicas -->
[resales_properties]

<!-- Con filtros específicos -->
[resales_properties agency_filter="destacados" limit="6"]
[resales_properties property_type="Villa" min_price="300000"]
[resales_properties location="Marbella" bedrooms="3"]
[resales_properties agency_filter="ventas" limit="12"]
```

#### **Parámetros Disponibles**:
- `agency_filter`: `"ventas"`, `"alquiler_largo"`, `"alquiler_corto"`, `"destacados"`
- `property_type`: `"Villa"`, `"Apartment"`, `"Townhouse"`, `"Penthouse"`, `"Bungalow"`
- `location`: Texto libre (ej: "Marbella", "Málaga")
- `min_price`: Precio mínimo en euros
- `max_price`: Precio máximo en euros
- `bedrooms`: Número mínimo de dormitorios
- `limit`: Número máximo de propiedades a mostrar (por defecto 12)

### 3. **[resales_properties_banner]** - Banner Principal
```html
[resales_properties_banner title="Propiedades Exclusivas" subtitle="Costa del Sol"]

<!-- Con valores por defecto -->
[resales_properties_banner]
```

---

## **Instalación**

### 📦 **Paso 1: Subir Archivos**
1. Subir la carpeta completa `resales-online-connector` a:
   ```
   /wp-content/plugins/resales-online-connector/
   ```

2. Verificar que la estructura sea correcta:
   ```
   wp-content/plugins/resales-online-connector/
   ├── resales-online-connector.php
   ├── elementor-integration.php
   ├── demo-data.php
   ├── assets/style.css
   ├── assets/script.js
   └── templates/...
   ```

### ⚡ **Paso 2: Activar Plugin**
1. Ir a **WordPress Admin** → **Plugins**
2. Buscar **"Resales Online API Connector"**
3. Hacer clic en **"Activar"**

### 🔑 **Paso 3: Configurar API (Opcional)**
1. Ir a **Ajustes** → **Resales Online**
2. Introducir **API Key**: `[Tu API Key]`
3. Seleccionar **Modo**: "Automático" (recomendado)
4. **Guardar cambios**

---

## **Configuración**

### 🎛️ **Panel de Administración**

#### **Ubicación**: `WordPress Admin → Ajustes → Resales Online`

#### **Opciones Disponibles**:

1. **API Key**
   - Campo para introducir tu clave de API de Resales Online
   - Requerida solo para el servidor de producción

2. **Modo de Funcionamiento**
   - **Automático** (recomendado): API real en producción, demo en desarrollo
   - **Siempre Demo**: Solo datos de demostración
   - **Siempre API**: Solo API real (puede fallar en development)

3. **Información del Sistema**
   - IP actual del servidor
   - Estado del entorno (desarrollo/producción)
   - Estado de conexión con Resales Online

### 🔧 **Configuraciones Avanzadas**

#### **En el código (si necesario)**:
```php
// Cambiar número de propiedades por defecto
'P_PageSize' => 20,  // Por defecto: 12

// Modificar filtros de agencia
private $malaga_filters = array(
    'ventas' => 1,
    'alquiler_corto' => 2,
    'alquiler_largo' => 3,
    'destacados' => 4
);
```

---

## **Uso Práctico**

### 🏠 **Escenarios de Uso Común**

#### **1. Página Principal**
```html
[resales_properties_banner title="Lusso Mediterráneo" subtitle="Propiedades exclusivas en la Costa del Sol"]

[resales_search_form]

[resales_properties agency_filter="destacados" limit="6"]
```

#### **2. Página de Ventas**
```html
<h2>Propiedades en Venta</h2>
[resales_search_form]
[resales_properties agency_filter="ventas" limit="12"]
```

#### **3. Página de Alquileres**
```html
<h2>Alquileres de Larga Duración</h2>
[resales_search_form]
[resales_properties agency_filter="alquiler_largo" limit="9"]
```

#### **4. Página de Villas Exclusivas**
```html
<h2>Villas de Lujo</h2>
[resales_properties property_type="Villa" min_price="500000" limit="8"]
```

### 🎨 **Integración con Elementor**

#### **Opción A: Usar tu Formulario Actual (Recomendado)**
- ✅ **Ventaja**: No cambias nada de tu diseño
- ✅ **Instalación**: Solo activar plugin
- ✅ **Resultado**: Tu formulario se vuelve funcional automáticamente

#### **Opción B: Usar Shortcodes del Plugin**
1. **Crear nueva página** en Elementor
2. **Añadir widget** "Shortcode"
3. **Insertar shortcode**: `[resales_search_form]`
4. **Añadir otro widget** "Shortcode"
5. **Insertar shortcode**: `[resales_properties limit="9"]`

### 📱 **Responsive Design**
El plugin está optimizado para todos los dispositivos:
- **Desktop**: Grid de 3-4 columnas
- **Tablet**: Grid de 2 columnas
- **Mobile**: Grid de 1 columna
- **Formularios**: Se adaptan automáticamente

---

## **Diseño y Estética**

### 🎨 **Paleta de Colores Lusso Mediterráneo**
- **Principal**: `#1a1a1a` (Negro elegante)
- **Secundario**: `#666666` (Gris medio)
- **Acentos**: `#ffffff` (Blanco puro)
- **Hover**: `#333333` (Gris oscuro)

### ✨ **Efectos y Animaciones**
- **Hover en tarjetas**: Elevación suave con sombra
- **Transiciones**: 0.3s ease para todos los elementos
- **Loading**: Spinner elegante durante búsquedas
- **Notificaciones**: Slide-in desde la derecha

### 📏 **Espaciado y Tipografía**
- **Grid gap**: 30px entre tarjetas
- **Padding**: 20px interno en tarjetas
- **Font**: -apple-system, BlinkMacSystemFont (sistema nativo)
- **Línea de altura**: 1.6 para legibilidad óptima

---

## **Solución de Problemas**

### ❓ **Problemas Comunes y Soluciones**

#### **1. El formulario no funciona**
**Síntomas**: El botón BUSCAR no hace nada
**Soluciones**:
- Verificar que el plugin esté activado
- Comprobar que la página tenga Elementor activo
- Revisar consola del navegador (F12) para errores JavaScript

#### **2. No aparecen propiedades**
**Síntomas**: Búsqueda exitosa pero sin resultados
**Soluciones**:
- Verificar filtros de búsqueda (muy restrictivos)
- Comprobar que haya datos demo disponibles
- Revisar configuración de API en modo producción

#### **3. Error de API en producción**
**Síntomas**: "Error de autenticación" o "IP no autorizada"
**Soluciones**:
- Verificar que la IP del servidor esté autorizada en Resales Online
- Confirmar que la API Key sea correcta
- El plugin cambiará automáticamente a modo demo si hay problemas

#### **4. Estilos no se aplican**
**Síntomas**: Formulario o propiedades sin estilo
**Soluciones**:
- Verificar que el archivo `assets/style.css` exista
- Comprobar que no haya conflictos con el theme
- Limpiar caché del navegador y plugins de cache

#### **5. Formulario de Elementor no se detecta**
**Síntomas**: La integración automática no funciona
**Soluciones**:
```javascript
// Añadir manualmente el selector del botón
const searchButton = $('.tu-clase-de-boton-buscar');
```

### 🔧 **Modo Debug**
Para diagnosticar problemas:

1. **Activar logs de WordPress**:
```php
// En wp-config.php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
```

2. **Usar shortcode de debug** (solo administradores):
```html
[resales_debug]
```

3. **Revisar logs en**:
```
/wp-content/debug.log
```

### 📞 **Soporte Técnico**

#### **Información para Reportar Problemas**:
1. **Versión de WordPress**
2. **Versión del plugin**
3. **Theme activo**
4. **Otros plugins activos**
5. **URL de la página con problema**
6. **Mensaje de error específico**
7. **Screenshot del problema**

---

## **Próximos Pasos y Actualizaciones**

### 🚀 **Funcionalidades Futuras**
- Integración con Google Maps para ubicaciones
- Slider de imágenes para cada propiedad
- Comparador de propiedades
- Sistema de favoritos
- Integración con CRM

### 📈 **Optimizaciones Planificadas**
- Caché inteligente de resultados de API
- Lazy loading para imágenes
- Compresión de assets CSS/JS
- Optimización SEO avanzada

### 🔄 **Mantenimiento**
- Actualizaciones automáticas de la API
- Monitoreo de uptime de Resales Online
- Logs de performance y uso
- Backup automático de configuraciones

---

## **Conclusión**

El **Plugin Resales Online API Connector** ofrece una **solución completa e inteligente** para mostrar propiedades inmobiliarias en WordPress. Su **integración automática con Elementor** permite aprovechar al máximo tu diseño actual, mientras que el **sistema dual demo/producción** garantiza un desarrollo sin fricciones.

### ✅ **Beneficios Principales**
- **Instalación instantánea** sin modificar tu diseño actual
- **Funcionamiento automático** en desarrollo y producción
- **Diseño profesional** coherente con Lusso Mediterráneo
- **Experiencia de usuario optimizada** en todos los dispositivos
- **Mantenimiento mínimo** con actualizaciones automáticas

**¡Tu formulario de Elementor está listo para mostrar propiedades reales de Resales Online!**

---

*Documento creado el 11 de agosto de 2025*
*Plugin desarrollado específicamente para Lusso Mediterráneo*
*Versión del documento: 1.0*
