<?php
/**
 * Plugin Name: Resales Online API Connector
 * Plugin URI: https://your-site.com
 * Description: Conecta tu sitio WordPress con la API de Resales Online para mostrar propiedades inmobiliarias.
 * Version: 1.1.0
 * Author: Tu Nombre
 * License: GPL v2 or later
 */

// Prevenir acceso directo
if (!defined('ABSPATH')) {
    exit;
}

// Definir constantes del plugin
define('RESALES_ONLINE_PLUGIN_URL', plugin_dir_url(__FILE__));
define('RESALES_ONLINE_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('RESALES_ONLINE_VERSION', '1.1.0');

// Incluir datos de demostración
require_once RESALES_ONLINE_PLUGIN_PATH . 'demo-data.php';

// Incluir integración con Elementor
require_once RESALES_ONLINE_PLUGIN_PATH . 'elementor-integration.php';

class ResalesOnlineConnector {

    private $p1; // Identificador de la agencia (P1)
    private $p2; // Clave de la agencia (P2)
    private $api_url = 'https://webapi.resales-online.com/V6/SearchProperties';
    private $agency_name = 'Lusso Mediterráneo';

    // Filtros predefinidos para Málaga
    private $malaga_filters = array(
        'ventas' => 1,           // FilterAgencyId :1 (Ventas)
        'alquiler_corto' => 2,   // FilterAgencyId :2 (Alquiler a corto plazo)
        'alquiler_largo' => 3,   // FilterAgencyId :3 (Alquiler a largo plazo)
        'destacados' => 4        // FilterAgencyId :4 (Destacados)
    );

    public function __construct() {
        add_action('init', array($this, 'init'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_shortcode('resales_properties', array($this, 'display_properties_shortcode'));
        add_shortcode('resales_search_form', array($this, 'display_search_form_shortcode'));
        add_shortcode('resales_properties_banner', array($this, 'display_properties_banner_shortcode'));
        add_shortcode('resales_debug', array($this, 'debug_api_shortcode'));

        // Hook para AJAX
        add_action('wp_ajax_resales_filter_properties', array($this, 'ajax_filter_properties'));
        add_action('wp_ajax_nopriv_resales_filter_properties', array($this, 'ajax_filter_properties'));

        // Hook para el admin
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'settings_init'));
    }

    public function init() {
        // Obtener las credenciales desde las opciones
        $this->p1 = get_option('resales_online_p1');
        $this->p2 = get_option('resales_online_p2');
    }

    public function enqueue_scripts() {
        wp_enqueue_style('resales-online-style', RESALES_ONLINE_PLUGIN_URL . 'assets/style.css', array(), RESALES_ONLINE_VERSION);
        wp_enqueue_script('resales-online-script', RESALES_ONLINE_PLUGIN_URL . 'assets/script.js', array('jquery'), RESALES_ONLINE_VERSION, true);

        // Localizar script para AJAX
        wp_localize_script('resales-online-script', 'resales_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('resales_nonce')
        ));
    }

    /**
     * Realizar consulta a la API de Resales Online
     */
    public function fetch_properties($params = array()) {
        // Verificar modo de demostración
        $demo_mode = get_option('resales_online_demo_mode', 'auto');

        if ($demo_mode === 'demo') {
            return $this->get_demo_data($params);
        }

        if (empty($this->p1) || empty($this->p2)) {
            if ($demo_mode === 'auto') {
                return $this->get_demo_data($params);
            }
            return new WP_Error('no_api_key', 'Identificador P1 o clave P2 no configurados');
        }

        // Si estamos en localhost y el modo es automático, usar datos de demo
        if ($demo_mode === 'auto' && $this->is_localhost()) {
            return $this->get_demo_data($params);
        }

        $default_params = array(
            'P1' => $this->p1,
            'P2' => $this->p2,
            'P_PageSize' => 20,
        );

        // Si se especifica un tipo de filtro de agencia, aplicarlo
        if (isset($params['agency_filter']) && isset($this->malaga_filters[$params['agency_filter']])) {
            $default_params['P_FilterAgencyId'] = $this->malaga_filters[$params['agency_filter']];
            unset($params['agency_filter']); // Remover para no incluir en la consulta final
        } else {
            // Por defecto, usar filtro de ventas
            $default_params['P_FilterAgencyId'] = 1;
        }

        $params = wp_parse_args($params, $default_params);

        // Usar GET en lugar de POST para esta API
        $url_with_params = $this->api_url . '?' . http_build_query($params);

        // Log para debug (remover en producción)
        error_log('Resales Online API Request URL: ' . $url_with_params);

        $response = wp_remote_get($url_with_params, array(
            'timeout' => 30,
            'headers' => array(
                'User-Agent' => 'WordPress/Lusso-Mediterraneo-Plugin'
            )
        ));

        if (is_wp_error($response)) {
            error_log('Resales Online API Error: ' . $response->get_error_message());
            if ($demo_mode === 'auto') {
                return $this->get_demo_data($params);
            }
            return $response;
        }

        $response_code = wp_remote_retrieve_response_code($response);
        $body = wp_remote_retrieve_body($response);

        // Log de la respuesta (remover en producción)
        error_log('Resales Online API Response Code: ' . $response_code);
        error_log('Resales Online API Response: ' . substr($body, 0, 500) . '...');

        if ($response_code === 401) {
            $error_data = json_decode($body, true);
            if (isset($error_data['transaction']['errordescription'])) {
                $errors = $error_data['transaction']['errordescription'];

                // Si hay error de IP y estamos en modo automático, usar datos de demostración
                if (strpos($body, 'IP does not match') !== false && $demo_mode === 'auto') {
                    error_log('Resales Online: IP no autorizada, usando datos de demostración');
                    return $this->get_demo_data($params);
                }

                $error_msg = 'Error de autenticación API: ';
                foreach ($errors as $code => $desc) {
                    $error_msg .= $desc . '. ';
                }
                return new WP_Error('api_auth_error', $error_msg . 'La API está configurada para el servidor de producción.');
            }

            if ($demo_mode === 'auto') {
                return $this->get_demo_data($params);
            }
            return new WP_Error('api_error', 'Error de autenticación con Resales Online API');
        }

        if ($response_code !== 200) {
            if ($demo_mode === 'auto') {
                return $this->get_demo_data($params);
            }
            return new WP_Error('api_error', 'Error de API: ' . $response_code . ' - ' . $body);
        }

        $data = json_decode($body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            if ($demo_mode === 'auto') {
                return $this->get_demo_data($params);
            }
            return new WP_Error('json_error', 'Error al decodificar JSON: ' . json_last_error_msg());
        }

        return $data;
    }

    /**
     * Verificar si estamos en localhost
     */
    private function is_localhost() {
        $server_ip = $_SERVER['SERVER_ADDR'] ?? '';
        $remote_ip = $_SERVER['REMOTE_ADDR'] ?? '';
        $http_host = $_SERVER['HTTP_HOST'] ?? '';

        return (
            strpos($server_ip, '127.0.0.1') !== false ||
            strpos($remote_ip, '127.0.0.1') !== false ||
            strpos($http_host, 'localhost') !== false ||
            strpos($http_host, '127.0.0.1') !== false
        );
    }

    /**
     * Obtener datos de demostración cuando la API no está disponible
     */
    private function get_demo_data($params) {
        $demo_data = get_demo_properties_data();
        $filtered_properties = $demo_data['Properties'];

        // Filtrado por ubicación, tipo, dormitorios, precio, etc. 
        // ... (Lógica igual que antes, no requiere cambios para P1/P2) ...

        // [Puedes copiar aquí tu lógica de filtrado como ya la tienes]
        // (Omitido por brevedad)

        $demo_data['Properties'] = array_values($filtered_properties);
        $demo_data['QueryInfo']['TotalCount'] = count($filtered_properties);

        return $demo_data;
    }

    /**
     * Shortcode para mostrar propiedades
     */
    public function display_properties_shortcode($atts) {
        $atts = shortcode_atts(array(
            'location' => '',
            'property_type' => '',
            'min_price' => '',
            'max_price' => '',
            'bedrooms' => '',
            'limit' => 12,
            'agency_filter' => '', // 'ventas', 'alquiler_corto', 'alquiler_largo', 'destacados'
        ), $atts);

        // Preparar parámetros para la API
        $api_params = array();

        if (!empty($atts['location'])) {
            $api_params['P_Location'] = $atts['location'];
        }
        if (!empty($atts['property_type'])) {
            $api_params['P_PropertyTypes'] = $atts['property_type'];
        }
        if (!empty($atts['min_price'])) {
            $api_params['P_PriceMin'] = intval($atts['min_price']);
        }
        if (!empty($atts['max_price'])) {
            $api_params['P_PriceMax'] = intval($atts['max_price']);
        }
        if (!empty($atts['bedrooms'])) {
            $api_params['P_Bedrooms'] = intval($atts['bedrooms']);
        }
        if (!empty($atts['agency_filter'])) {
            $api_params['agency_filter'] = $atts['agency_filter'];
        }
        $api_params['P_PageSize'] = intval($atts['limit']);

        // Obtener propiedades
        $properties = $this->fetch_properties($api_params);

        if (is_wp_error($properties)) {
            return '<p>Error al cargar las propiedades: ' . $properties->get_error_message() . '</p>';
        }

        // Generar HTML
        ob_start();
        include RESALES_ONLINE_PLUGIN_PATH . 'templates/properties-grid.php';
        return ob_get_clean();
    }

    /**
     * Shortcode para mostrar el formulario de búsqueda
     */
    public function display_search_form_shortcode($atts) {
        ob_start();
        include RESALES_ONLINE_PLUGIN_PATH . 'templates/search-form.php';
        return ob_get_clean();
    }

    /**
     * Shortcode para mostrar banner de propiedades
     */
    public function display_properties_banner_shortcode($atts) {
        $atts = shortcode_atts(array(
            'title' => 'Propiedades Exclusivas en la Costa del Sol',
            'subtitle' => 'Descubre las mejores oportunidades inmobiliarias en ubicaciones privilegiadas del Mediterráneo.',
        ), $atts);

        ob_start();
        ?>
        <div class="resales-properties-banner">
            <div class="banner-content">
                <h1 class="banner-title"><?php echo esc_html($atts['title']); ?></h1>
                <p class="banner-subtitle"><?php echo esc_html($atts['subtitle']); ?></p>
            </div>
        </div>
        <style>
        .resales-properties-banner {
            text-align: center;
            padding: 5rem 2rem;
            background: linear-gradient(135deg, rgba(26, 26, 26, 0.05) 0%, rgba(26, 26, 26, 0.02) 100%);
            margin-bottom: 4rem;
        }
        .banner-title { font-size: 2.8rem; font-weight: 300; color: #1a1a1a; margin-bottom: 1.5rem; letter-spacing: 0.5px; line-height: 1.2; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif; }
        .banner-subtitle { font-size: 1.2rem; color: #666666; font-weight: 300; line-height: 1.6; max-width: 700px; margin: 0 auto; }
        @media (max-width: 768px) {
            .resales-properties-banner { padding: 3rem 1rem; }
            .banner-title { font-size: 2rem; }
            .banner-subtitle { font-size: 1rem; }
        }
        </style>
        <?php
        return ob_get_clean();
    }

    /**
     * Shortcode para debug de la API (temporal)
     */
    public function debug_api_shortcode($atts) {
        if (!current_user_can('manage_options')) {
            return '<p>Acceso denegado.</p>';
        }

        $properties = $this->fetch_properties(array('P_PageSize' => 1));

        ob_start();
        echo '<div style="background: #f1f1f1; padding: 20px; border: 1px solid #ddd; margin: 20px 0;">';
        echo '<h3>Debug API Resales Online</h3>';
        echo '<strong>P1 configurado:</strong> ' . (empty($this->p1) ? 'NO' : 'SÍ') . '<br>';
        echo '<strong>P2 configurado:</strong> ' . (empty($this->p2) ? 'NO' : 'SÍ') . '<br>';
        echo '<strong>URL API:</strong> ' . $this->api_url . '<br><br>';

        if (is_wp_error($properties)) {
            echo '<strong>Error:</strong> ' . $properties->get_error_message();
        } else {
            echo '<strong>Respuesta exitosa</strong><br>';
            echo '<strong>Datos recibidos:</strong><br>';
            echo '<pre>' . json_encode($properties, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . '</pre>';
        }
        echo '</div>';
        return ob_get_clean();
    }

    /**
     * AJAX handler para filtrar propiedades
     */
    public function ajax_filter_properties() {
        check_ajax_referer('resales_nonce', 'nonce');

        $params = array();
        if (!empty($_POST['location'])) { $params['P_Location'] = sanitize_text_field($_POST['location']); }
        if (!empty($_POST['property_type'])) { $params['P_PropertyTypes'] = sanitize_text_field($_POST['property_type']); }
        if (!empty($_POST['min_price'])) { $params['P_PriceMin'] = intval($_POST['min_price']); }
        if (!empty($_POST['max_price'])) { $params['P_PriceMax'] = intval($_POST['max_price']); }
        if (!empty($_POST['bedrooms'])) { $params['P_Bedrooms'] = intval($_POST['bedrooms']); }

        $properties = $this->fetch_properties($params);

        if (is_wp_error($properties)) {
            wp_send_json_error('Error al cargar las propiedades');
        }

        ob_start();
        include RESALES_ONLINE_PLUGIN_PATH . 'templates/properties-grid.php';
        $html = ob_get_clean();

        wp_send_json_success(array('html' => $html));
    }

    /**
     * Agregar menú de administración
     */
    public function add_admin_menu() {
        add_options_page(
            'Resales Online Settings',
            'Resales Online',
            'manage_options',
            'resales-online',
            array($this, 'options_page')
        );
    }

    /**
     * Inicializar configuraciones
     */
    public function settings_init() {
        register_setting('resales_online', 'resales_online_p1'); // Identificador
        register_setting('resales_online', 'resales_online_p2'); // Clave
        register_setting('resales_online', 'resales_online_demo_mode');

        add_settings_section(
            'resales_online_settings_section',
            'Configuración de API',
            array($this, 'settings_section_callback'),
            'resales_online'
        );

        add_settings_field(
            'resales_online_p1',
            'P1 (Identificador)',
            array($this, 'p1_render'),
            'resales_online',
            'resales_online_settings_section'
        );

        add_settings_field(
            'resales_online_p2',
            'P2 (Clave)',
            array($this, 'p2_render'),
            'resales_online',
            'resales_online_settings_section'
        );

        add_settings_field(
            'resales_online_demo_mode',
            'Modo de Demostración',
            array($this, 'demo_mode_render'),
            'resales_online',
            'resales_online_settings_section'
        );
    }

    public function p1_render() {
        $p1 = get_option('resales_online_p1');
        echo '<input type="text" name="resales_online_p1" value="' . esc_attr($p1) . '" size="50" />';
        echo '<p class="description">Introduce tu identificador P1 (Agency ID)</p>';
    }

    public function p2_render() {
        $p2 = get_option('resales_online_p2');
        echo '<input type="password" name="resales_online_p2" value="' . esc_attr($p2) . '" size="50" />';
        echo '<p class="description">Introduce tu clave P2 (API Key)</p>';
    }

    public function demo_mode_render() {
        $demo_mode = get_option('resales_online_demo_mode', 'auto');
        ?>
        <select name="resales_online_demo_mode">
            <option value="auto" <?php selected($demo_mode, 'auto'); ?>>Automático (API en producción, demo en desarrollo)</option>
            <option value="demo" <?php selected($demo_mode, 'demo'); ?>>Siempre usar datos de demostración</option>
            <option value="api" <?php selected($demo_mode, 'api'); ?>>Siempre usar API real</option>
        </select>
        <p class="description">
            <strong>Automático:</strong> Usa API real si está disponible, datos de demo si hay error de IP.<br>
            <strong>Nota:</strong> La API de Resales Online está autorizada para el servidor de producción del cliente, no para localhost.
        </p>
        <?php
    }

    public function settings_section_callback() {
        $current_ip = $this->get_current_server_ip();
        ?>
        <p>Configura tu conexión con Resales Online API V6</p>
        <div style="background: #f0f8ff; border: 1px solid #0073aa; padding: 15px; margin: 15px 0; border-radius: 3px;">
            <h4 style="margin-top: 0;">ℹ️ Información Importante:</h4>
            <ul style="margin-bottom: 0;">
                <li><strong>IP actual del servidor:</strong> <?php echo $current_ip; ?></li>
                <li><strong>Entorno actual:</strong> <?php echo (strpos($current_ip, '127.0.0.1') !== false || strpos($current_ip, 'localhost') !== false) ? 'Desarrollo (localhost)' : 'Servidor'; ?></li>
                <li>La API de Resales Online está autorizada para funcionar desde el servidor de producción del cliente</li>
                <li>En desarrollo local se usan datos de demostración automáticamente</li>
            </ul>
        </div>
        <?php
    }

    /**
     * Obtener la IP actual del servidor
     */
    private function get_current_server_ip() {
        $ip_sources = array(
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_REAL_IP',
            'HTTP_CLIENT_IP',
            'REMOTE_ADDR',
            'SERVER_ADDR'
        );

        foreach ($ip_sources as $source) {
            if (!empty($_SERVER[$source])) {
                $ip = $_SERVER[$source];
                if (strpos($ip, ',') !== false) {
                    $ip = trim(explode(',', $ip)[0]);
                }
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
                    return $ip;
                }
            }
        }
        return isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : '127.0.0.1 (localhost)';
    }

    public function options_page() {
        ?>
        <form action='options.php' method='post'>
            <h1>Resales Online Settings</h1>
            <?php
            settings_fields('resales_online');
            do_settings_sections('resales_online');
            submit_button();
            ?>
        </form>
        <?php
    }
}

// Inicializar el plugin
$resales_connector = new ResalesOnlineConnector();

// Hook de activación
register_activation_hook(__FILE__, 'resales_online_activate');
function resales_online_activate() {
    flush_rewrite_rules();
}

// Hook de desactivación
register_deactivation_hook(__FILE__, 'resales_online_deactivate');
function resales_online_deactivate() {
    flush_rewrite_rules();
}