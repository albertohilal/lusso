# 🚀 Instalación Rápida - Plugin Resales Online

## ✅ Pasos de Instalación (5 minutos)

### 1. **Subir Archivos** 
Copia toda la carpeta `resales-online-connector` a:
```
/wp-content/plugins/resales-online-connector/
```

### 2. **Activar Plugin**
- Ve a **WordPress Admin → Plugins**
- Busca **"Resales Online API Connector"**
- Haz clic en **"Activar"**

### 3. **¡YA FUNCIONA!** 
Tu formulario de Elementor ahora es completamente funcional.

---

## 🎯 Verificación Rápida

### ✅ **Checklist Post-Instalación**
- [ ] Plugin aparece en lista de plugins activos
- [ ] Opción "Resales Online" visible en **Ajustes**
- [ ] Al visitar página con formulario, aparece en consola: `🔍 Resales Online: Integrando con formulario de Elementor`
- [ ] Botón "BUSCAR" responde con efecto loading

### 🔧 **Configuración Opcional**
- **Ajustes → Resales Online**
- **API Key**: `6492b10667a9b8945336f9c80ed478228ff728b` (ya configurada)
- **Modo**: "Automático" (recomendado)

---

## 🎨 Tu Formulario Actual + Plugin = ✨

### **ANTES** (Solo Visual)
```
[Formulario Elementor] → No funciona
```

### **DESPUÉS** (Completamente Funcional)
```
[Formulario Elementor] → 🔍 API Resales Online → 🏠 Propiedades Reales
```

---

## 📋 Dos Formas de Usar

### **Opción A: Mantener tu Formulario Actual (Recomendado)**
- ✅ No cambias nada de tu diseño
- ✅ Instalación: Solo activar plugin
- ✅ Resultado: Formulario se vuelve funcional automáticamente

### **Opción B: Usar Shortcodes del Plugin**
```html
<!-- En cualquier página/post -->
[resales_search_form]
[resales_properties agency_filter="destacados" limit="6"]
```

---

## 🐛 ¿Algo no funciona?

### **Debug Rápido**
1. **Abrir consola del navegador** (F12)
2. **Buscar mensaje**: `🔍 Resales Online: Integrando...`
3. **Si no aparece**: Plugin no está detectando el formulario

### **Solución Inmediata**
```javascript
// Añadir en consola para test manual
jQuery('.tu-boton-buscar').trigger('click');
```

---

## 📞 Soporte

### **Información para Debug**
- **URL página con problema**: 
- **Versión WordPress**: 
- **Theme activo**: 
- **Mensaje error consola**: 

### **Archivos de Log**
- WordPress: `/wp-content/debug.log`
- Plugin: Buscar "Resales Online" en logs

---

## 🚀 ¡Listo para Producción!

Cuando subas a servidor real:
1. **Plugin detecta automáticamente** entorno producción
2. **Se conecta a API real** de Resales Online
3. **Muestra propiedades reales** de tu agencia
4. **¡Sin configuración adicional!**

---

**¡Tu integración está completa en menos de 5 minutos!** 🎉
