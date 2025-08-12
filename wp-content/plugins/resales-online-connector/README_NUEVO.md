# Resales Online API Connector

Plugin WordPress para integrar la API V6 de Resales Online con diseño optimizado para Lusso Mediterráneo.

## 🚀 Instalación Rápida

1. **Subir plugin** a `/wp-content/plugins/resales-online-connector/`
2. **Activar** en WordPress Admin → Plugins
3. **¡Listo!** Tu formulario de Elementor ya funciona con la API

## ⚡ Características

- ✅ **Integración automática** con formularios de Elementor existentes
- ✅ **Sistema dual**: Demo en desarrollo, API real en producción
- ✅ **Responsive design** optimizado para todos los dispositivos
- ✅ **Estética Lusso Mediterráneo** con colores corporativos
- ✅ **Búsqueda avanzada** con filtros múltiples

## 📋 Shortcodes

```html
<!-- Formulario de búsqueda -->
[resales_search_form]

<!-- Grid de propiedades -->
[resales_properties]
[resales_properties agency_filter="destacados" limit="6"]
[resales_properties property_type="Villa" min_price="300000"]

<!-- Banner principal -->
[resales_properties_banner title="Propiedades Exclusivas"]
```

## 🔧 Configuración

**WordPress Admin → Ajustes → Resales Online**

- **API Key**: Tu clave de Resales Online (solo producción)
- **Modo**: Automático (recomendado)

## 🎯 Uso con Elementor

**Tu formulario actual funcionará automáticamente.** El plugin detecta:
- Botones "BUSCAR"
- Campos de ubicación (placeholder "Málaga...")
- Selects de tipo, precio, dormitorios

## 🏗️ Estructura

```
resales-online-connector/
├── resales-online-connector.php    # Plugin principal
├── elementor-integration.php       # Integración Elementor
├── demo-data.php                   # Datos de demo
├── assets/
│   ├── style.css                   # Estilos CSS
│   └── script.js                   # JavaScript
├── templates/
│   ├── search-form.php             # Formulario
│   └── properties-grid.php         # Grid propiedades
├── DOCUMENTACION.md                # Guía completa
└── README.md                       # Este archivo
```

## 🔄 Funcionamiento

### Desarrollo (Localhost)
- Detecta automáticamente entorno local
- Usa datos demo realistas (6 propiedades Costa del Sol)
- Filtros funcionales para testing

### Producción (Servidor Real)  
- Detecta servidor de producción
- Conecta con API real de Resales Online
- Propiedades actualizadas en tiempo real

## 🎨 API Resales Online V6

- **URL**: `https://webapi.resales-online.com/V6/SearchProperties`
- **Método**: GET
- **Autenticación**: IP + API Key
- **Filtros**: Agencia, tipo, precio, ubicación, dormitorios

### Filtros Predefinidos
- `ventas` → FilterAgencyId: 1
- `alquiler_corto` → FilterAgencyId: 2  
- `alquiler_largo` → FilterAgencyId: 3
- `destacados` → FilterAgencyId: 4

## 🐛 Debug

```html
<!-- Solo para administradores -->
[resales_debug]
```

Ver logs en `/wp-content/debug.log`

## 📱 Responsive

- **Desktop**: Grid 3-4 columnas
- **Tablet**: Grid 2 columnas  
- **Mobile**: Grid 1 columna
- **Formularios**: Adaptación automática

## 🎯 Ejemplos de Uso

### Página Principal
```html
[resales_properties_banner]
[resales_search_form]  
[resales_properties agency_filter="destacados" limit="6"]
```

### Página Ventas
```html
[resales_search_form]
[resales_properties agency_filter="ventas" limit="12"]
```

### Villas Exclusivas
```html
[resales_properties property_type="Villa" min_price="500000"]
```

## ⚠️ Solución de Problemas

| Problema | Solución |
|----------|----------|
| Formulario no funciona | Verificar plugin activo + Elementor |
| No aparecen propiedades | Revisar filtros muy restrictivos |
| Error API producción | Plugin cambia automáticamente a demo |
| Estilos no se aplican | Limpiar cache + verificar assets/ |

## 📈 Performance

- **Detección automática** de entorno
- **Caché inteligente** de resultados
- **Assets optimizados** (CSS/JS minificado)
- **Lazy loading** para imágenes
- **SEO optimizado** con meta tags

## 🔐 Seguridad

- **Sanitización** de todos los inputs
- **Nonces** para AJAX requests
- **Validación** de permisos de usuario
- **Escape** de outputs HTML
- **Rate limiting** en búsquedas

## 📄 Licencia

GPL v2 or later - Compatible con WordPress

## 🎨 Créditos

- **Desarrollado para**: Lusso Mediterráneo
- **API**: Resales Online V6
- **Framework**: WordPress + Elementor
- **Fecha**: Agosto 2025

---

Para documentación completa ver: `DOCUMENTACION.md`
