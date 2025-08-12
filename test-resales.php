<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Resales Online Plugin - Lusso Mediterráneo</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background: #f8f9fa;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #1a1a1a;
            text-align: center;
            margin-bottom: 30px;
            font-weight: 300;
            letter-spacing: 0.5px;
        }
        .test-section {
            margin: 40px 0;
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            background: #fafafa;
        }
        .test-section h2 {
            color: #333;
            margin-top: 0;
            font-size: 1.4rem;
            font-weight: 400;
        }
        .shortcode-info {
            background: #e8f4ff;
            padding: 10px;
            margin: 10px 0;
            border-left: 4px solid #0073aa;
            font-family: monospace;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🏖️ Test Resales Online Plugin - Lusso Mediterráneo</h1>
        
        <div class="test-section">
            <h2>📋 1. Formulario de Búsqueda</h2>
            <div class="shortcode-info">[resales_search_form]</div>
            <?php
            // Simular WordPress environment mínimo
            define('ABSPATH', __DIR__ . '/');
            if (!function_exists('esc_attr')) {
                function esc_attr($text) { return htmlspecialchars($text, ENT_QUOTES, 'UTF-8'); }
            }
            if (!function_exists('selected')) {
                function selected($selected, $current, $echo = true) {
                    $result = ($selected == $current) ? ' selected="selected"' : '';
                    if ($echo) echo $result;
                    return $result;
                }
            }
            
            // Incluir el formulario directamente
            include __DIR__ . '/wp-content/plugins/resales-online-connector/templates/search-form.php';
            ?>
        </div>

        <div class="test-section">
            <h2>🏠 2. Propiedades Destacadas (Demo)</h2>
            <div class="shortcode-info">[resales_properties agency_filter="destacados" limit="3"]</div>
            <?php
            // Simular algunos datos para mostrar el diseño
            $demo_properties = array(
                array(
                    'Reference' => 'LUSSO001',
                    'PropertyType' => 'Villa',
                    'Location' => 'Marbella',
                    'Province' => 'Málaga',
                    'Price' => 850000,
                    'Bedrooms' => 4,
                    'Bathrooms' => 3,
                    'BuiltArea' => 280,
                    'PlotArea' => 800,
                    'MainImage' => 'https://via.placeholder.com/400x300/1a1a1a/ffffff?text=Villa+Marbella',
                    'Description' => 'Espectacular villa con vistas al mar en una de las zonas más exclusivas de Marbella.',
                ),
                array(
                    'Reference' => 'LUSSO002', 
                    'PropertyType' => 'Apartment',
                    'Location' => 'Puerto Banús',
                    'Province' => 'Málaga',
                    'Price' => 650000,
                    'Bedrooms' => 2,
                    'Bathrooms' => 2,
                    'BuiltArea' => 120,
                    'PlotArea' => 0,
                    'MainImage' => 'https://via.placeholder.com/400x300/666666/ffffff?text=Apartamento+Puerto+Banus',
                    'Description' => 'Moderno apartamento en primera línea de playa con acceso directo al puerto deportivo.',
                ),
                array(
                    'Reference' => 'LUSSO003',
                    'PropertyType' => 'Penthouse',
                    'Location' => 'Estepona',
                    'Province' => 'Málaga', 
                    'Price' => 1200000,
                    'Bedrooms' => 3,
                    'Bathrooms' => 3,
                    'BuiltArea' => 200,
                    'PlotArea' => 150,
                    'MainImage' => 'https://via.placeholder.com/400x300/4a90e2/ffffff?text=Penthouse+Estepona',
                    'Description' => 'Exclusivo ático dúplex con terraza panorámica y vistas espectaculares al Mediterráneo.',
                )
            );
            ?>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 30px; margin-top: 20px;">
                <?php foreach ($demo_properties as $property): ?>
                <div style="border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; background: white; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                    <img src="<?php echo $property['MainImage']; ?>" 
                         alt="<?php echo $property['PropertyType'] . ' en ' . $property['Location']; ?>"
                         style="width: 100%; height: 200px; object-fit: cover;">
                    
                    <div style="padding: 20px;">
                        <div style="display: flex; justify-content: between; align-items: center; margin-bottom: 10px;">
                            <span style="background: #1a1a1a; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: 500;">
                                <?php echo $property['PropertyType']; ?>
                            </span>
                            <span style="color: #666; font-size: 14px;">
                                Ref: <?php echo $property['Reference']; ?>
                            </span>
                        </div>
                        
                        <h3 style="margin: 0 0 10px 0; font-size: 1.2rem; font-weight: 500; color: #1a1a1a;">
                            <?php echo $property['PropertyType'] . ' en ' . $property['Location']; ?>
                        </h3>
                        
                        <p style="color: #666; margin: 0 0 15px 0; font-size: 14px; line-height: 1.4;">
                            <?php echo substr($property['Description'], 0, 100) . '...'; ?>
                        </p>
                        
                        <div style="display: flex; gap: 15px; margin-bottom: 15px; color: #666; font-size: 14px;">
                            <span>🛏️ <?php echo $property['Bedrooms']; ?></span>
                            <span>🛁 <?php echo $property['Bathrooms']; ?></span>
                            <span>📐 <?php echo $property['BuiltArea']; ?>m²</span>
                        </div>
                        
                        <div style="display: flex; justify-content: between; align-items: center;">
                            <span style="font-size: 1.4rem; font-weight: 600; color: #1a1a1a;">
                                €<?php echo number_format($property['Price'], 0, ',', '.'); ?>
                            </span>
                            <button style="background: #1a1a1a; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer; font-size: 14px;">
                                Ver Detalles
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="test-section">
            <h2>ℹ️ Información del Plugin</h2>
            <ul style="color: #666; line-height: 2;">
                <li><strong>Estado:</strong> Plugin activo con datos de demostración</li>
                <li><strong>API:</strong> Resales Online V6 (configurada para servidor de producción)</li>
                <li><strong>Shortcodes disponibles:</strong></li>
                <ul style="margin-left: 20px; color: #888;">
                    <li><code>[resales_search_form]</code> - Formulario de búsqueda</li>
                    <li><code>[resales_properties]</code> - Grid de propiedades</li>
                    <li><code>[resales_properties_banner]</code> - Banner principal</li>
                </ul>
                <li><strong>Estilo:</strong> Integrado con el diseño de Lusso Mediterráneo</li>
                <li><strong>Responsivo:</strong> ✅ Optimizado para móviles y tablets</li>
            </ul>
        </div>

        <div class="test-section" style="text-align: center; background: linear-gradient(135deg, #1a1a1a 0%, #333 100%); color: white;">
            <h2 style="color: white;">🚀 ¿Listo para Producción?</h2>
            <p>Cuando subas el plugin al servidor de producción:</p>
            <ol style="text-align: left; max-width: 500px; margin: 0 auto; color: #ccc;">
                <li>El plugin detectará automáticamente el entorno de producción</li>
                <li>Se conectará a la API real de Resales Online</li>
                <li>Mostrará las propiedades reales de tu agencia</li>
                <li>El formulario funcionará con filtros en tiempo real</li>
            </ol>
        </div>
    </div>

    <script>
        // Añadir algunos efectos hover a las tarjetas de propiedades
        document.querySelectorAll('[style*="border: 1px solid #e0e0e0"]').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.boxShadow = '0 8px 25px rgba(0,0,0,0.15)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'none';
            });
        });
    </script>
</body>
</html>
