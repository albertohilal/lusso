# Plugin Resales Online Connector - Lusso Mediterráneo

## 🚀 Configuración y Uso

### ⚡ Activación Automática en Producción

**¡IMPORTANTE!** Este plugin está diseñado para funcionar automáticamente:

- **En desarrollo (localhost):** Muestra propiedades de demostración
- **En producción:** Se conecta automáticamente con la API de Resales Online

### 🔧 Configuración

1. **Panel de Administración:** Ve a `Ajustes > Resales Online`
2. **API Key:** Ya está configurada: `6492b10667a9b8945336f9c80ed478228ff728b`
3. **Modo:** Mantén en "Automático" para mejor funcionamiento

### 📋 Shortcodes Disponibles

#### Banner Principal
```html
[resales_properties_banner title="Tu Título" subtitle="Tu subtítulo"]
```

#### Formulario de Búsqueda
```html
[resales_search_form]
```

#### Propiedades por Tipo de Operación
```html
<!-- Propiedades destacadas -->
[resales_properties agency_filter="destacados" limit="3"]

<!-- Propiedades en venta -->
[resales_properties agency_filter="ventas" limit="9"]

<!-- Alquiler vacacional (corto plazo) -->
[resales_properties agency_filter="alquiler_corto" limit="6"]

<!-- Alquiler residencial (largo plazo) -->
[resales_properties agency_filter="alquiler_largo" limit="6"]
```

#### Filtros Combinados
```html
<!-- Villas en venta entre 500k-2M euros -->
[resales_properties agency_filter="ventas" property_type="Villa" min_price="500000" max_price="2000000" limit="6"]

<!-- Apartamentos para alquiler vacacional -->
[resales_properties agency_filter="alquiler_corto" property_type="Apartment" limit="8"]
```

### 🎯 Filtros Disponibles

- **agency_filter:** `ventas`, `alquiler_corto`, `alquiler_largo`, `destacados`
- **property_type:** `Villa`, `Apartment`, `Townhouse`, `Penthouse`, `Bungalow`
- **min_price / max_price:** Precio en euros
- **bedrooms:** Número mínimo de dormitorios
- **limit:** Número de propiedades a mostrar

### 🌐 Despliegue en Producción

**Cuando subas el sitio al servidor de producción:**

1. ✅ **La API se activará automáticamente** (está autorizada para tu servidor)
2. ✅ **No necesitas cambiar ninguna configuración**
3. ✅ **Las propiedades reales reemplazarán a las de demostración**

### 🎨 Integración con Lusso Mediterráneo

El plugin está completamente adaptado a la estética de tu sitio web:

- **Colores:** Paleta neutra (#1a1a1a, #666666, #ffffff)
- **Tipografía:** Fuentes minimalistas con espaciado elegante
- **Animaciones:** Suaves y profesionales
- **Responsive:** Optimizado para todos los dispositivos

### 📱 Ejemplo de Página Completa

```html
[resales_properties_banner title="Propiedades Exclusivas Costa del Sol" subtitle="Descubre las mejores oportunidades inmobiliarias en Málaga"]

[resales_search_form]

<h2 style="text-align: center; margin: 3rem 0 2rem;">Propiedades Destacadas</h2>
[resales_properties agency_filter="destacados" limit="3"]

<h2 style="text-align: center; margin: 3rem 0 2rem;">Propiedades en Venta</h2>
[resales_properties agency_filter="ventas" limit="9"]

<h2 style="text-align: center; margin: 3rem 0 2rem;">Alquiler Vacacional</h2>
[resales_properties agency_filter="alquiler_corto" limit="6"]
```

### 🛠️ Soporte Técnico

Para cualquier ajuste o personalización adicional, contacta con el equipo de desarrollo.

### 📊 Estado del Plugin

- ✅ API Key configurada
- ✅ Filtros de Málaga activados
- ✅ Datos de demostración funcionando en desarrollo
- ✅ Listo para producción automática
- ✅ Estética Lusso Mediterráneo integrada
