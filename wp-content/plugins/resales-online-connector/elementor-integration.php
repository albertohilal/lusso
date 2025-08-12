<?php
/**
 * Integración con Elementor para formularios existentes
 * Este archivo hace funcionar los formularios creados en Elementor
 */

// Prevenir acceso directo
if (!defined('ABSPATH')) {
    exit;
}

class ResalesElementorIntegration {
    
    public function __construct() {
        // Hook para interceptar formularios de búsqueda
        add_action('wp_footer', array($this, 'add_search_functionality'));
        add_action('wp_ajax_resales_elementor_search', array($this, 'handle_elementor_search'));
        add_action('wp_ajax_nopriv_resales_elementor_search', array($this, 'handle_elementor_search'));
    }
    
    /**
     * Añadir funcionalidad JavaScript a formularios de Elementor
     */
    public function add_search_functionality() {
        if (!$this->is_elementor_page_with_search()) {
            return;
        }
        ?>
        <script>
        jQuery(document).ready(function($) {
            console.log('🔍 Resales Online: Integrando con formulario de Elementor');
            
            // DEBUG: Mostrar todos los selects en la página
            const allSelects = $('select');
            console.log('🔍 DEBUG: Total selects en página:', allSelects.length);
            allSelects.each(function(i) {
                const sel = $(this);
                console.log(`Select ${i+1}:`, {
                    id: sel.attr('id'),
                    class: sel.attr('class'),
                    options: sel.find('option').map(function() { return $(this).text(); }).get()
                });
            });
            
            // Buscar el botón de búsqueda con múltiples selectores
            let searchButton = $('a[href*="BUSCAR"], button:contains("BUSCAR"), .elementor-button:contains("BUSCAR")');
            
            // Si no encuentra con :contains, probar con texto exacto
            if (searchButton.length === 0) {
                searchButton = $('a, button, .elementor-button').filter(function() {
                    return $(this).text().trim().toUpperCase().includes('BUSCAR');
                });
            }
            
            // Si aún no encuentra, buscar por clases comunes de Elementor
            if (searchButton.length === 0) {
                searchButton = $('.elementor-button-link, .elementor-button-text, button[type="submit"]');
                console.log('🔍 Intentando con selectores de Elementor:', searchButton.length);
            }
            
            // Si aún no encuentra, buscar cualquier elemento con "buscar" en el texto
            if (searchButton.length === 0) {
                searchButton = $('*').filter(function() {
                    const text = $(this).text().trim().toLowerCase();
                    return text === 'buscar' && $(this).is('a, button, span, div');
                });
                console.log('🔍 Búsqueda por texto genérico:', searchButton.length);
            }
            
            console.log('🔍 Botones encontrados:', searchButton.length, searchButton);
            
            if (searchButton.length > 0) {
                console.log('✅ Botón de búsqueda encontrado');
                
                // Convertir link en botón funcional
                searchButton.off('click').on('click', function(e) {
                    e.preventDefault();
                    console.log('🚀 Click en botón BUSCAR detectado');
                    handleElementorSearch();
                });
                
                // Cambiar cursor para indicar que es clickeable
                searchButton.css('cursor', 'pointer');
            } else {
                console.log('❌ No se encontró botón BUSCAR');
                console.log('🔍 Buscando manualmente todos los elementos con texto...');
                $('a, button, span, div').each(function() {
                    const text = $(this).text().trim();
                    if (text.toLowerCase().includes('buscar')) {
                        console.log('📍 Encontrado elemento con "buscar":', this, text);
                    }
                });
            }
            
            /**
             * Manejar búsqueda desde formulario de Elementor
             */
            function handleElementorSearch() {
                console.log('🚀 Iniciando búsqueda...');
                
                // Obtener valores de los campos del formulario
                const searchParams = getElementorFormValues();
                
                // Mostrar loading
                showSearchLoading();
                
                // Realizar búsqueda AJAX
                $.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    type: 'POST',
                    data: {
                        action: 'resales_elementor_search',
                        nonce: '<?php echo wp_create_nonce('resales_elementor_nonce'); ?>',
                        ...searchParams
                    },
                    success: function(response) {
                        console.log('✅ Búsqueda completada:', response);
                        
                        if (response.success) {
                            displaySearchResults(response.data);
                        } else {
                            showSearchError(response.data);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('❌ Error en búsqueda:', error);
                        showSearchError('Error de conexión. Inténtalo de nuevo.');
                    },
                    complete: function() {
                        hideSearchLoading();
                    }
                });
            }
            
            /**
             * Obtener valores del formulario de Elementor
             */
            function getElementorFormValues() {
                const params = {};
                
                console.log('🔍 Analizando formulario de Elementor...');
                
                // Buscar campo de ubicación por placeholder
                const locationField = $('input[placeholder*="Málaga"], input[placeholder*="ubicación"], input[placeholder*="Ubicación"]');
                if (locationField.length > 0 && locationField.val()) {
                    params.location = locationField.val();
                    console.log('📍 Ubicación encontrada:', params.location);
                }
                
                // Buscar todos los selects y analizarlos individualmente
                const selects = $('.elementor-field-group select, .elementor-widget select');
                console.log('🔍 Total de selects encontrados:', selects.length);
                
                selects.each(function(index) {
                    const select = $(this);
                    const value = select.val();
                    const selectedText = select.find('option:selected').text().trim();
                    
                    console.log(`Select ${index + 1}:`, {
                        value: value,
                        selectedText: selectedText,
                        allOptions: select.find('option').map(function() { return $(this).text(); }).get()
                    });
                    
                    // Solo procesar si tiene un valor válido seleccionado
                    if (!value || value === '' || selectedText === 'Seleccionar...' || selectedText === '' || selectedText.includes('Seleccionar')) {
                        console.log(`⏭️ Saltando select ${index + 1}: valor vacío o placeholder`);
                        return; // Continuar con el siguiente select
                    }
                    
                    // Obtener todas las opciones del select para detectar el tipo
                    const options = select.find('option').map(function() {
                        return $(this).text().toLowerCase();
                    }).get().join(' ');
                    
                    console.log(`🔍 Analizando select ${index + 1} con opciones:`, options);
                    
                    // Detectar TIPO DE OPERACIÓN (Venta, Alquiler, etc.)
                    if (options.includes('venta') || options.includes('alquiler') || 
                        options.includes('todas las operaciones') || options.includes('operacion') ||
                        selectedText.toLowerCase().includes('venta') || 
                        selectedText.toLowerCase().includes('alquiler')) {
                        params.agency_filter = mapOperationType(selectedText);
                        console.log('💼 Tipo de operación detectado:', selectedText, '→', params.agency_filter);
                    }
                    // Detectar TIPO DE PROPIEDAD (Villa, Apartamento, etc.)
                    else if (options.includes('villa') || options.includes('apartamento') || 
                            options.includes('casa') || options.includes('piso') || options.includes('ático') ||
                            options.includes('duplex') || options.includes('bungalow') ||
                            selectedText.toLowerCase().includes('villa') || 
                            selectedText.toLowerCase().includes('apartamento') ||
                            selectedText.toLowerCase().includes('casa') ||
                            selectedText.toLowerCase().includes('ático') ||
                            selectedText.toLowerCase().includes('duplex')) {
                        params.property_type = mapPropertyType(selectedText);
                        console.log('🏠 Tipo de propiedad detectado:', selectedText, '→', params.property_type);
                    }
                    // Detectar DORMITORIOS
                    else if (options.includes('dormitorio') || options.includes('habitacion') ||
                            options.includes('bedroom') || /\d+\s*(dorm|hab|bed)/i.test(options) ||
                            selectedText.includes('dormitorio') || /\d+\+?\s*dormitorio/i.test(selectedText)) {
                        params.bedrooms = mapBedrooms(selectedText, value);
                        console.log('🛏️ Dormitorios detectados:', selectedText, '→', params.bedrooms);
                    }
                    // Detectar PRECIOS (€, euro, precio)
                    else if (options.includes('€') || options.includes('euro') || 
                            options.includes('precio') || /\d+\.?\d*\s*(€|euro)/i.test(options) ||
                            selectedText.includes('€') || selectedText.includes('euro') ||
                            selectedText.toLowerCase().includes('precio') || /\d+/i.test(selectedText)) {
                        
                        // Determinar si es precio mínimo o máximo basado en el texto
                        if (selectedText.toLowerCase().includes('sin mínimo') || selectedText.toLowerCase().includes('min')) {
                            // Es un precio mínimo, pero "sin mínimo" no se aplica
                            if (!selectedText.toLowerCase().includes('sin mínimo')) {
                                params.min_price = extractPriceFromText(selectedText, value);
                                console.log('💰 Precio mínimo detectado:', selectedText, '→', params.min_price);
                            }
                        } else if (selectedText.toLowerCase().includes('sin máximo') || selectedText.toLowerCase().includes('max')) {
                            // Es un precio máximo, pero "sin máximo" no se aplica
                            if (!selectedText.toLowerCase().includes('sin máximo')) {
                                params.max_price = extractPriceFromText(selectedText, value);
                                console.log('💰 Precio máximo detectado:', selectedText, '→', params.max_price);
                            }
                        } else {
                            // Detectar automáticamente si es mínimo o máximo basado en la posición
                            if (!params.min_price) {
                                params.min_price = extractPriceFromText(selectedText, value);
                                console.log('💰 Precio mínimo (auto):', selectedText, '→', params.min_price);
                            } else {
                                params.max_price = extractPriceFromText(selectedText, value);
                                console.log('💰 Precio máximo (auto):', selectedText, '→', params.max_price);
                            }
                        }
                    }
                });
                
                console.log('📝 Parámetros finales de búsqueda:', params);
                return params;
            }
            
            /**
             * Mapear tipos de operación
             */
            function mapOperationType(value) {
                const lowerValue = value.toLowerCase().trim();
                
                const mapping = {
                    'venta': 'ventas',
                    'ventas': 'ventas',
                    'sale': 'ventas',
                    'for sale': 'ventas',
                    'alquiler largo': 'alquiler_largo',
                    'alquiler largo plazo': 'alquiler_largo', 
                    'long term rental': 'alquiler_largo',
                    'alquiler corto': 'alquiler_corto',
                    'alquiler corto plazo': 'alquiler_corto',
                    'short term rental': 'alquiler_corto',
                    'vacation rental': 'alquiler_corto',
                    'destacados': 'destacados',
                    'featured': 'destacados'
                };
                
                const result = mapping[lowerValue] || 'ventas';
                console.log('🔄 Mapeando operación:', value, '→', result);
                return result;
            }
            
            /**
             * Mapear tipos de propiedad
             */
            function mapPropertyType(value) {
                const lowerValue = value.toLowerCase().trim();
                
                const mapping = {
                    'villa': 'Villa',
                    'villas': 'Villa',
                    'apartamento': 'Apartment',
                    'apartamentos': 'Apartment',
                    'apartment': 'Apartment',
                    'piso': 'Apartment',
                    'pisos': 'Apartment',
                    'casa': 'Villa',
                    'casas': 'Villa',
                    'house': 'Villa',
                    'ático': 'Penthouse',
                    'atico': 'Penthouse',
                    'attico': 'Penthouse',
                    'penthouse': 'Penthouse',
                    'duplex': 'Apartment',
                    'dúplex': 'Apartment',
                    'bungalow': 'Bungalow',
                    'townhouse': 'Townhouse',
                    'adosado': 'Townhouse'
                };
                
                const result = mapping[lowerValue] || value;
                console.log('🔄 Mapeando tipo de propiedad:', value, '→', result);
                return result;
            }
            
            /**
             * Mapear número de dormitorios
             */
            function mapBedrooms(text, value) {
                // Si el text contiene "4+" o similar, devolver 4
                if (text.includes('4+') || text.includes('4 o más') || text.includes('4+')) {
                    return 4;
                }
                
                // Extraer número del texto
                const match = text.match(/(\d+)/);
                if (match) {
                    return parseInt(match[1]);
                }
                
                // Si no encuentra número en el texto, usar el value
                return parseInt(value) || 1;
            }
            
            /**
             * Extraer precio del texto
             */
            function extractPriceFromText(text, value) {
                // Si el value es numérico, usarlo directamente
                if (!isNaN(value) && value !== '') {
                    return parseInt(value);
                }
                
                // Extraer precio del texto (buscar números con puntos o comas)
                const match = text.match(/(\d+[\.,]?\d*)/);
                if (match) {
                    return parseInt(match[1].replace(/[\.,]/g, ''));
                }
                
                return null;
            }
            
            /**
             * Mostrar loading durante búsqueda
             */
            function showSearchLoading() {
                const button = $('a[href*="BUSCAR"], button:contains("BUSCAR"), .elementor-button:contains("BUSCAR")');
                button.html('<i class="fa fa-spinner fa-spin"></i> Buscando...');
                button.prop('disabled', true);
            }
            
            /**
             * Ocultar loading
             */
            function hideSearchLoading() {
                const button = $('a[href*="BUSCAR"], button:contains("BUSCAR"), .elementor-button:contains("BUSCAR")');
                button.html('<i class="fa fa-search"></i> BUSCAR');
                button.prop('disabled', false);
            }
            
            /**
             * Mostrar resultados de búsqueda
             */
            function displaySearchResults(data) {
                // Crear contenedor de resultados si no existe
                let resultsContainer = $('#resales-search-results');
                if (resultsContainer.length === 0) {
                    resultsContainer = $('<div id="resales-search-results" style="margin-top: 40px;"></div>');
                    $('.elementor-section').last().after(resultsContainer);
                }
                
                // Mostrar resultados
                resultsContainer.html(data.html);
                
                // Scroll suave a resultados
                $('html, body').animate({
                    scrollTop: resultsContainer.offset().top - 100
                }, 800);
                
                // Mostrar mensaje de éxito
                showNotification('✅ Se encontraron ' + data.count + ' propiedades', 'success');
            }
            
            /**
             * Mostrar error de búsqueda
             */
            function showSearchError(message) {
                showNotification('❌ ' + message, 'error');
            }
            
            /**
             * Mostrar notificaciones
             */
            function showNotification(message, type) {
                const notification = $(`
                    <div class="resales-notification resales-notification-${type}" style="
                        position: fixed; 
                        top: 20px; 
                        right: 20px; 
                        z-index: 999999;
                        background: ${type === 'success' ? '#4CAF50' : '#f44336'};
                        color: white;
                        padding: 15px 20px;
                        border-radius: 5px;
                        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                        font-weight: 500;
                        max-width: 300px;
                    ">${message}</div>
                `);
                
                $('body').append(notification);
                
                // Auto-ocultar después de 4 segundos
                setTimeout(function() {
                    notification.fadeOut(500, function() {
                        $(this).remove();
                    });
                }, 4000);
            }
        });
        </script>
        
        <style>
        /* Estilos para resultados de búsqueda */
        #resales-search-results {
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .resales-notification {
            animation: slideInRight 0.3s ease-out;
        }
        
        @keyframes slideInRight {
            from { transform: translateX(100%); }
            to { transform: translateX(0); }
        }
        </style>
        <?php
    }
    
    /**
     * Verificar si es una página de Elementor con formulario de búsqueda
     */
    private function is_elementor_page_with_search() {
        // Verificar si es una página con Elementor
        if (!class_exists('\Elementor\Plugin')) {
            return false;
        }
        
        // Verificar si hay contenido que sugiere un formulario de búsqueda
        global $post;
        if (!$post) {
            return false;
        }
        
        $content = $post->post_content;
        return (
            strpos($content, 'BUSCAR') !== false ||
            strpos($content, 'search') !== false ||
            strpos($content, 'Propiedades') !== false
        );
    }
    
    /**
     * Manejar búsqueda desde Elementor
     */
    public function handle_elementor_search() {
        check_ajax_referer('resales_elementor_nonce', 'nonce');
        
        // Obtener instancia del plugin principal
        global $resales_connector;
        if (!$resales_connector) {
            $resales_connector = new ResalesOnlineConnector();
        }
        
        // Preparar parámetros de búsqueda
        $params = array();
        
        if (!empty($_POST['location'])) {
            $params['P_Location'] = sanitize_text_field($_POST['location']);
        }
        
        if (!empty($_POST['property_type'])) {
            $params['P_PropertyTypes'] = sanitize_text_field($_POST['property_type']);
        }
        
        if (!empty($_POST['min_price'])) {
            $params['P_PriceMin'] = intval($_POST['min_price']);
        }
        
        if (!empty($_POST['max_price'])) {
            $params['P_PriceMax'] = intval($_POST['max_price']);
        }
        
        if (!empty($_POST['bedrooms'])) {
            $params['P_Bedrooms'] = intval($_POST['bedrooms']);
        }
        
        if (!empty($_POST['agency_filter'])) {
            $params['agency_filter'] = sanitize_text_field($_POST['agency_filter']);
        }
        
        $params['P_PageSize'] = 12;
        
        // Realizar búsqueda
        $properties = $resales_connector->fetch_properties($params);
        
        if (is_wp_error($properties)) {
            wp_send_json_error('Error al cargar las propiedades: ' . $properties->get_error_message());
            return;
        }
        
        // Generar HTML de resultados
        ob_start();
        $this->render_search_results($properties);
        $html = ob_get_clean();
        
        wp_send_json_success(array(
            'html' => $html,
            'count' => isset($properties['QueryInfo']['TotalCount']) ? $properties['QueryInfo']['TotalCount'] : count($properties['Properties'])
        ));
    }
    
    /**
     * Renderizar resultados de búsqueda
     */
    private function render_search_results($properties) {
        if (empty($properties['Properties'])) {
            echo '<div style="text-align: center; padding: 40px; color: #666;">';
            echo '<h3>No se encontraron propiedades</h3>';
            echo '<p>Intenta ajustar los criterios de búsqueda.</p>';
            echo '</div>';
            return;
        }
        
        echo '<div class="resales-properties-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 30px; margin: 40px 0; padding: 0 20px;">';
        
        foreach ($properties['Properties'] as $property) {
            $this->render_property_card($property);
        }
        
        echo '</div>';
    }
    
    /**
     * Renderizar tarjeta de propiedad
     */
    private function render_property_card($property) {
        $price = number_format($property['Price'], 0, ',', '.');
        $location = $property['Location'] . ', ' . $property['Province'];
        $image = $property['MainImage'] ?? 'https://via.placeholder.com/400x300/1a1a1a/ffffff?text=' . urlencode($property['PropertyType']);
        
        ?>
        <div class="resales-property-card" style="
            background: white; 
            border-radius: 8px; 
            overflow: hidden; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        " onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 30px rgba(0,0,0,0.15)';"
           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 20px rgba(0,0,0,0.1)';">
            
            <div style="position: relative;">
                <img src="<?php echo esc_url($image); ?>" 
                     alt="<?php echo esc_attr($property['PropertyType'] . ' en ' . $location); ?>"
                     style="width: 100%; height: 200px; object-fit: cover;">
                
                <div style="position: absolute; bottom: 10px; left: 10px; background: rgba(0,0,0,0.8); color: white; padding: 8px 12px; border-radius: 4px; font-size: 14px;">
                    <?php echo esc_html($property['PropertyType']); ?>
                </div>
                
                <div style="position: absolute; bottom: 10px; right: 10px; background: rgba(26,26,26,0.9); color: white; padding: 8px 12px; border-radius: 4px; font-weight: 600;">
                    €<?php echo $price; ?>
                </div>
            </div>
            
            <div style="padding: 20px;">
                <h3 style="margin: 0 0 10px 0; font-size: 1.2rem; font-weight: 500; color: #1a1a1a;">
                    <?php echo esc_html($location); ?>
                </h3>
                
                <p style="color: #666; margin: 0 0 15px 0; font-size: 14px; line-height: 1.4;">
                    <?php echo esc_html(substr($property['Description'] ?? '', 0, 100) . '...'); ?>
                </p>
                
                <div style="display: flex; gap: 15px; margin-bottom: 15px; color: #666; font-size: 14px;">
                    <?php if ($property['Bedrooms']): ?>
                    <span>🛏️ <?php echo $property['Bedrooms']; ?></span>
                    <?php endif; ?>
                    
                    <?php if ($property['Bathrooms']): ?>
                    <span>🛁 <?php echo $property['Bathrooms']; ?></span>
                    <?php endif; ?>
                    
                    <?php if ($property['BuiltArea']): ?>
                    <span>📐 <?php echo $property['BuiltArea']; ?>m²</span>
                    <?php endif; ?>
                </div>
                
                <button style="
                    background: #1a1a1a; 
                    color: white; 
                    border: none; 
                    padding: 12px 20px; 
                    border-radius: 4px; 
                    cursor: pointer; 
                    font-size: 14px;
                    width: 100%;
                    transition: background 0.3s ease;
                " onmouseover="this.style.background='#333';" 
                   onmouseout="this.style.background='#1a1a1a';">
                    Ver Detalles
                </button>
            </div>
        </div>
        <?php
    }
}

// Inicializar integración con Elementor
new ResalesElementorIntegration();
?>
