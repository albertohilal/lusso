<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Formulario - Resales Online</title>
    <link rel="stylesheet" href="wp-content/plugins/resales-online-connector/assets/style.css">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 40px 20px;
            background: #f8f9fa;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        h1 {
            color: #1a1a1a;
            text-align: center;
            margin-bottom: 40px;
            font-weight: 300;
            font-size: 2.5rem;
        }
        .test-info {
            background: #e8f4ff;
            padding: 20px;
            margin-bottom: 30px;
            border-left: 4px solid #0073aa;
            border-radius: 4px;
        }
        .visibilidad-check {
            background: #f0f8ff;
            padding: 15px;
            margin: 20px 0;
            border: 2px solid #4CAF50;
            border-radius: 6px;
        }
        .visibilidad-check h3 {
            color: #2e7d32;
            margin-top: 0;
        }
        .check-item {
            display: flex;
            align-items: center;
            margin: 10px 0;
        }
        .check-item::before {
            content: "✅";
            margin-right: 10px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Test Formulario Mejorado</h1>
        
        <div class="test-info">
            <h3>📋 Verificación de Visibilidad</h3>
            <p>Este formulario ha sido optimizado para resolver el problema de campos "semi ocultos".</p>
        </div>

        <div class="visibilidad-check">
            <h3>✅ Mejoras Implementadas:</h3>
            <div class="check-item">Bordes sólidos de 2px para mayor definición</div>
            <div class="check-item">Padding aumentado a 18px para mejor espacio interno</div>
            <div class="check-item">Estados de focus con color y sombra destacados</div>
            <div class="check-item">Labels claros y descriptivos</div>
            <div class="check-item">Placeholders informativos</div>
            <div class="check-item">Contraste optimizado para mejor legibilidad</div>
            <div class="check-item">Responsive design para todos los dispositivos</div>
        </div>

        <?php
        // Funciones WordPress mínimas para el test
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
        
        // Simular algunos valores para mostrar el formulario en acción
        $_GET = array(
            'location' => '',
            'property_type' => 'Villa',
            'bedrooms' => '3',
            'min_price' => '300000'
        );
        
        // Incluir el formulario mejorado
        include __DIR__ . '/wp-content/plugins/resales-online-connector/templates/search-form.php';
        ?>

        <div style="margin-top: 40px; padding: 30px; background: linear-gradient(135deg, #1a1a1a 0%, #333 100%); color: white; border-radius: 8px; text-align: center;">
            <h3 style="color: white; margin-top: 0;">🎯 Estado del Formulario</h3>
            <p style="margin-bottom: 0; color: #ccc;">
                El formulario ahora tiene campos <strong>completamente visibles</strong> con bordes definidos, 
                mejor contraste y espaciado optimizado. El problema de campos "semi ocultos" ha sido resuelto.
            </p>
        </div>

        <div style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 6px;">
            <h4 style="color: #333; margin-top: 0;">📱 Test de Responsividad</h4>
            <p style="color: #666; margin-bottom: 10px;">
                Cambia el tamaño de la ventana o usa las herramientas de desarrollo para verificar 
                que el formulario se adapta correctamente a diferentes tamaños de pantalla.
            </p>
            <div style="display: flex; gap: 15px; margin-top: 15px;">
                <button onclick="testResponsive('1200px')" style="padding: 8px 16px; border: 1px solid #ddd; background: white; border-radius: 4px; cursor: pointer;">Desktop</button>
                <button onclick="testResponsive('768px')" style="padding: 8px 16px; border: 1px solid #ddd; background: white; border-radius: 4px; cursor: pointer;">Tablet</button>
                <button onclick="testResponsive('480px')" style="padding: 8px 16px; border: 1px solid #ddd; background: white; border-radius: 4px; cursor: pointer;">Mobile</button>
                <button onclick="testResponsive('100%')" style="padding: 8px 16px; border: 1px solid #ddd; background: white; border-radius: 4px; cursor: pointer;">Normal</button>
            </div>
        </div>
    </div>

    <script>
        // Función para test de responsividad
        function testResponsive(width) {
            const container = document.querySelector('.container');
            container.style.maxWidth = width;
            container.style.transition = 'max-width 0.5s ease';
        }

        // Verificar que todos los campos son visibles al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input, select');
            let allVisible = true;
            
            inputs.forEach(input => {
                const style = window.getComputedStyle(input);
                const rect = input.getBoundingClientRect();
                
                if (rect.height < 30 || style.opacity < 0.5 || style.visibility === 'hidden') {
                    allVisible = false;
                    console.warn('Campo posiblemente no visible:', input);
                }
            });
            
            if (allVisible) {
                console.log('✅ Todos los campos del formulario son visibles');
            } else {
                console.warn('⚠️ Algunos campos podrían tener problemas de visibilidad');
            }
        });

        // Añadir efectos de focus mejorados
        document.querySelectorAll('input, select').forEach(field => {
            field.addEventListener('focus', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 4px 12px rgba(26, 26, 26, 0.1)';
            });
            
            field.addEventListener('blur', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'none';
            });
        });
    </script>
</body>
</html>
