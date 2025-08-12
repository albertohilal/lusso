<?php
/**
 * Template para el formulario de búsqueda de propiedades
 */
?>

<form class="resales-search-form" method="get" role="search" aria-label="Buscar propiedades">
    <div class="search-fields">
        <div class="field-group">
            <label for="location">Ubicación</label>
            <input type="text" 
                   id="location" 
                   name="location" 
                   placeholder="Ej: Málaga, Marbella..."
                   value="<?php echo esc_attr($_GET['location'] ?? ''); ?>"
                   autocomplete="address-level2">
        </div>
        
        <div class="field-group">
            <label for="agency_filter">Tipo de Operación</label>
            <select id="agency_filter" name="agency_filter" aria-describedby="agency_filter_desc">
                <option value="">Todas las operaciones</option>
                <option value="venta" <?php selected($_GET['agency_filter'] ?? '', 'venta'); ?>>Venta</option>
                <option value="alquiler_largo" <?php selected($_GET['agency_filter'] ?? '', 'alquiler_largo'); ?>>Alquiler largo plazo</option>
                <option value="alquiler_corto" <?php selected($_GET['agency_filter'] ?? '', 'alquiler_corto'); ?>>Alquiler corto plazo</option>
                <option value="destacados" <?php selected($_GET['agency_filter'] ?? '', 'destacados'); ?>>Propiedades destacadas</option>
            </select>
        </div>
        
        <div class="field-group">
            <label for="property_type">Tipo de Propiedad</label>
            <select id="property_type" name="property_type">
                <option value="">Todos los tipos</option>
                <option value="Villa" <?php selected($_GET['property_type'] ?? '', 'Villa'); ?>>Villa</option>
                <option value="Apartment" <?php selected($_GET['property_type'] ?? '', 'Apartment'); ?>>Apartamento</option>
                <option value="Townhouse" <?php selected($_GET['property_type'] ?? '', 'Townhouse'); ?>>Casa adosada</option>
                <option value="Penthouse" <?php selected($_GET['property_type'] ?? '', 'Penthouse'); ?>>Ático</option>
                <option value="Bungalow" <?php selected($_GET['property_type'] ?? '', 'Bungalow'); ?>>Bungalow</option>
            </select>
        </div>
        
        <div class="field-group">
            <label for="bedrooms">Dormitorios</label>
            <select id="bedrooms" name="bedrooms">
                <option value="">Cualquier cantidad</option>
                <option value="1" <?php selected($_GET['bedrooms'] ?? '', '1'); ?>>1+ dormitorio</option>
                <option value="2" <?php selected($_GET['bedrooms'] ?? '', '2'); ?>>2+ dormitorios</option>
                <option value="3" <?php selected($_GET['bedrooms'] ?? '', '3'); ?>>3+ dormitorios</option>
                <option value="4" <?php selected($_GET['bedrooms'] ?? '', '4'); ?>>4+ dormitorios</option>
                <option value="5" <?php selected($_GET['bedrooms'] ?? '', '5'); ?>>5+ dormitorios</option>
            </select>
        </div>
        
        <div class="field-group">
            <label for="min_price">Precio Mínimo</label>
            <select id="min_price" name="min_price">
                <option value="">Sin mínimo</option>
                <option value="50000" <?php selected($_GET['min_price'] ?? '', '50000'); ?>>€50,000</option>
                <option value="100000" <?php selected($_GET['min_price'] ?? '', '100000'); ?>>€100,000</option>
                <option value="200000" <?php selected($_GET['min_price'] ?? '', '200000'); ?>>€200,000</option>
                <option value="300000" <?php selected($_GET['min_price'] ?? '', '300000'); ?>>€300,000</option>
                <option value="500000" <?php selected($_GET['min_price'] ?? '', '500000'); ?>>€500,000</option>
                <option value="1000000" <?php selected($_GET['min_price'] ?? '', '1000000'); ?>>€1,000,000</option>
            </select>
        </div>
        
        <div class="field-group">
            <label for="max_price">Precio Máximo</label>
            <select id="max_price" name="max_price">
                <option value="">Sin máximo</option>
                <option value="100000" <?php selected($_GET['max_price'] ?? '', '100000'); ?>>€100,000</option>
                <option value="200000" <?php selected($_GET['max_price'] ?? '', '200000'); ?>>€200,000</option>
                <option value="300000" <?php selected($_GET['max_price'] ?? '', '300000'); ?>>€300,000</option>
                <option value="500000" <?php selected($_GET['max_price'] ?? '', '500000'); ?>>€500,000</option>
                <option value="1000000" <?php selected($_GET['max_price'] ?? '', '1000000'); ?>>€1,000,000</option>
                <option value="2000000" <?php selected($_GET['max_price'] ?? '', '2000000'); ?>>€2,000,000</option>
            </select>
        </div>
        
        <div class="field-group">
            <button type="submit" class="search-btn" aria-label="Buscar propiedades">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.35-4.35"></path>
                </svg>
                Buscar
            </button>
        </div>
    </div>
</form>

<style>
.resales-search-form {
    background: #ffffff;
    padding: 3rem 2rem;
    border-radius: 0;
    margin-bottom: 4rem;
    border: 1px solid rgba(0, 0, 0, 0.08);
    box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
}

.search-fields {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    align-items: end;
}

.field-group {
    display: flex;
    flex-direction: column;
    position: relative;
}

.field-group label {
    font-weight: 500;
    margin-bottom: 12px;
    color: #1a1a1a;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
}

.field-group input,
.field-group select {
    padding: 18px 16px;
    border: 2px solid rgba(0, 0, 0, 0.1);
    border-radius: 0;
    font-size: 15px;
    background: #ffffff;
    color: #1a1a1a;
    font-weight: 400;
    transition: all 0.3s ease;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
}

/* Flecha personalizada para select */
.field-group select {
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23333' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 16px center;
    background-size: 16px;
    padding-right: 50px;
    cursor: pointer;
}

.field-group input:focus,
.field-group select:focus {
    outline: none;
    border-color: #1a1a1a;
    box-shadow: 0 0 0 3px rgba(26, 26, 26, 0.1);
    background: #fafafa;
}

.field-group input::placeholder {
    color: #999999;
    font-weight: 300;
    font-style: italic;
}

.field-group input:hover,
.field-group select:hover {
    border-color: rgba(0, 0, 0, 0.2);
}

.search-btn {
    background: #1a1a1a;
    color: #ffffff;
    border: 2px solid #1a1a1a;
    padding: 18px 35px;
    border-radius: 0;
    cursor: pointer;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 12px;
    justify-content: center;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    font-size: 12px;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
    min-height: 58px;
    white-space: nowrap;
}

.search-btn:hover {
    background: transparent;
    color: #1a1a1a;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(26, 26, 26, 0.2);
}

.search-btn i {
    font-size: 16px;
}

/* Estados de validación */
.field-group input:invalid {
    border-color: #dc3545;
}

.field-group input:valid {
    border-color: rgba(40, 167, 69, 0.3);
}

/* Responsive mejorado */
@media (max-width: 1024px) {
    .search-fields {
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.5rem;
    }
}

@media (max-width: 768px) {
    .search-fields {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .resales-search-form {
        padding: 2rem 1.5rem;
        margin-bottom: 3rem;
    }
    
    .field-group input,
    .field-group select {
        padding: 16px 14px;
        font-size: 16px; /* Evitar zoom en iOS */
    }
    
    .field-group select {
        padding-right: 45px;
    }
    
    .search-btn {
        padding: 16px 30px;
        font-size: 11px;
        letter-spacing: 1px;
    }
}

@media (max-width: 480px) {
    .field-group label {
        font-size: 12px;
        margin-bottom: 10px;
    }
    
    .search-btn {
        width: 100%;
    }
}

/* Animación de carga para el formulario */
.resales-search-form.loading .search-btn {
    pointer-events: none;
    opacity: 0.7;
}

.resales-search-form.loading .search-btn::after {
    content: '';
    width: 16px;
    height: 16px;
    border: 2px solid transparent;
    border-top: 2px solid currentColor;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin-left: 10px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
