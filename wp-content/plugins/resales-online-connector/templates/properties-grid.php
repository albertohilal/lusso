<?php
/**
 * Template para mostrar la grilla de propiedades
 */

if (empty($properties)) {
    echo '<div class="resales-no-properties">';
    echo '<p>No se pudieron cargar las propiedades en este momento. Por favor, intenta más tarde.</p>';
    echo '</div>';
    return;
}

if (!isset($properties['Properties']) || empty($properties['Properties'])) {
    echo '<div class="resales-no-properties">';
    echo '<p>No se encontraron propiedades que coincidan con los criterios de búsqueda.</p>';
    if (isset($properties['QueryInfo']['TotalCount'])) {
        echo '<p><small>Total de propiedades en la base de datos: ' . $properties['QueryInfo']['TotalCount'] . '</small></p>';
    }
    echo '</div>';
    return;
}

$properties_list = $properties['Properties'];

// Verificar si estamos usando datos de demostración
$is_demo = (isset($properties_list[0]['PropertyId']) && strpos($properties_list[0]['PropertyId'], 'DEMO') !== false);
?>

<?php if ($is_demo && current_user_can('manage_options')): ?>
<div class="resales-demo-notice">
    <p><strong>🎭 Modo Demostración:</strong> Mostrando propiedades de ejemplo. En el servidor de producción se conectará automáticamente con la API de Resales Online.</p>
</div>
<?php endif; ?>

<div class="resales-properties-grid">
    <?php foreach ($properties_list as $property): ?>
        <div class="resales-property-card">
            <?php if (!empty($property['MainImage'])): ?>
                <div class="property-image">
                    <img src="<?php echo esc_url($property['MainImage']); ?>" 
                         alt="<?php echo esc_attr($property['PropertyName']); ?>" 
                         loading="lazy">
                    
                    <?php if (!empty($property['Price'])): ?>
                        <div class="property-price">
                            €<?php echo number_format($property['Price'], 0, ',', '.'); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <div class="property-details">
                <h3 class="property-title">
                    <?php echo esc_html($property['PropertyName']); ?>
                </h3>
                
                <div class="property-location">
                    <i class="fas fa-map-marker-alt"></i>
                    <?php 
                    $location = array();
                    if (!empty($property['Town'])) $location[] = $property['Town'];
                    if (!empty($property['Province'])) $location[] = $property['Province'];
                    echo esc_html(implode(', ', $location));
                    ?>
                </div>
                
                <div class="property-features">
                    <?php if (!empty($property['Bedrooms'])): ?>
                        <span class="feature">
                            <i class="fas fa-bed"></i>
                            <?php echo intval($property['Bedrooms']); ?> hab.
                        </span>
                    <?php endif; ?>
                    
                    <?php if (!empty($property['Bathrooms'])): ?>
                        <span class="feature">
                            <i class="fas fa-bath"></i>
                            <?php echo intval($property['Bathrooms']); ?> baños
                        </span>
                    <?php endif; ?>
                    
                    <?php if (!empty($property['SurfaceArea'])): ?>
                        <span class="feature">
                            <i class="fas fa-expand-arrows-alt"></i>
                            <?php echo intval($property['SurfaceArea']); ?> m²
                        </span>
                    <?php endif; ?>
                </div>
                
                <?php if (!empty($property['Description'])): ?>
                    <div class="property-description">
                        <?php echo wp_trim_words($property['Description'], 20, '...'); ?>
                    </div>
                <?php endif; ?>
                
                <div class="property-actions">
                    <a href="<?php echo esc_url($property['MoreDetailsURL']); ?>" 
                       class="btn btn-primary" target="_blank">
                        Ver Detalles
                    </a>
                    
                    <?php if (!empty($property['AgentEmail'])): ?>
                        <a href="mailto:<?php echo esc_attr($property['AgentEmail']); ?>" 
                           class="btn btn-secondary">
                            Contactar
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php if (isset($properties['TotalPages']) && $properties['TotalPages'] > 1): ?>
    <div class="resales-pagination">
        <!-- Aquí puedes agregar paginación si es necesario -->
    </div>
<?php endif; ?>
