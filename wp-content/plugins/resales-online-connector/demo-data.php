<?php
/**
 * Datos de demostración para el plugin Resales Online
 * Usar mientras se configura la IP correcta en Resales Online
 */

function get_demo_properties_data() {
    return array(
        'QueryInfo' => array(
            'TotalCount' => 25,
            'CurrentPage' => 1,
            'PageSize' => 12
        ),
        'Properties' => array(
            array(
                'PropertyId' => 'DEMO001',
                'PropertyName' => 'Villa de Lujo en Marbella Golden Mile',
                'Town' => 'Marbella',
                'Province' => 'Málaga',
                'Price' => 2850000,
                'Bedrooms' => 4,
                'Bathrooms' => 3,
                'SurfaceArea' => 350,
                'Description' => 'Espectacular villa de diseño moderno ubicada en la exclusiva Milla de Oro de Marbella. Esta propiedad única combina elegancia contemporánea con las mejores vistas al mar Mediterráneo.',
                'MainImage' => 'https://images.unsplash.com/photo-1613490493576-7fde63acd811?w=800&h=600&fit=crop',
                'MoreDetailsURL' => '#propiedad-demo-001',
                'AgentEmail' => 'info@lussomediterraneo.eu',
                'PropertyType' => 'Villa'
            ),
            array(
                'PropertyId' => 'DEMO002',
                'PropertyName' => 'Apartamento Exclusivo Puerto Banús',
                'Town' => 'Marbella',
                'Province' => 'Málaga',
                'Price' => 1250000,
                'Bedrooms' => 3,
                'Bathrooms' => 2,
                'SurfaceArea' => 180,
                'Description' => 'Apartamento de lujo completamente renovado en primera línea del puerto deportivo más exclusivo de la Costa del Sol. Acabados premium y vistas impresionantes.',
                'MainImage' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=800&h=600&fit=crop',
                'MoreDetailsURL' => '#propiedad-demo-002',
                'AgentEmail' => 'info@lussomediterraneo.eu',
                'PropertyType' => 'Apartment'
            ),
            array(
                'PropertyId' => 'DEMO003',
                'PropertyName' => 'Villa Moderna Vista al Mar Estepona',
                'Town' => 'Estepona',
                'Province' => 'Málaga',
                'Price' => 1890000,
                'Bedrooms' => 5,
                'Bathrooms' => 4,
                'SurfaceArea' => 420,
                'Description' => 'Nueva construcción con arquitectura vanguardista y tecnología domótica avanzada. Jardín mediterráneo y piscina infinity con vistas panorámicas al mar.',
                'MainImage' => 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800&h=600&fit=crop',
                'MoreDetailsURL' => '#propiedad-demo-003',
                'AgentEmail' => 'info@lussomediterraneo.eu',
                'PropertyType' => 'Villa'
            ),
            array(
                'PropertyId' => 'DEMO004',
                'PropertyName' => 'Ático Dúplex con Terraza Panorámica',
                'Town' => 'Mijas',
                'Province' => 'Málaga',
                'Price' => 875000,
                'Bedrooms' => 3,
                'Bathrooms' => 2,
                'SurfaceArea' => 220,
                'Description' => 'Espectacular ático dúplex con terraza de 150m² y vistas de 360 grados. Acabados de primera calidad y ubicación privilegiada cerca del campo de golf.',
                'MainImage' => 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=800&h=600&fit=crop',
                'MoreDetailsURL' => '#propiedad-demo-004',
                'AgentEmail' => 'info@lussomediterraneo.eu',
                'PropertyType' => 'Penthouse'
            ),
            array(
                'PropertyId' => 'DEMO005',
                'PropertyName' => 'Casa Adosada de Diseño Benahavís',
                'Town' => 'Benahavís',
                'Province' => 'Málaga',
                'Price' => 650000,
                'Bedrooms' => 3,
                'Bathrooms' => 3,
                'SurfaceArea' => 240,
                'Description' => 'Casa adosada de nueva construcción en exclusiva urbanización con seguridad 24h. Piscina comunitaria, spa y club social. Ideal para familias.',
                'MainImage' => 'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?w=800&h=600&fit=crop',
                'MoreDetailsURL' => '#propiedad-demo-005',
                'AgentEmail' => 'info@lussomediterraneo.eu',
                'PropertyType' => 'Townhouse'
            ),
            array(
                'PropertyId' => 'DEMO006',
                'PropertyName' => 'Bungalow Frente al Mar Fuengirola',
                'Town' => 'Fuengirola',
                'Province' => 'Málaga',
                'Price' => 485000,
                'Bedrooms' => 2,
                'Bathrooms' => 2,
                'SurfaceArea' => 120,
                'Description' => 'Encantador bungalow a pocos metros de la playa con jardín privado y acceso directo al paseo marítimo. Completamente reformado con estilo mediterráneo.',
                'MainImage' => 'https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde?w=800&h=600&fit=crop',
                'MoreDetailsURL' => '#propiedad-demo-006',
                'AgentEmail' => 'info@lussomediterraneo.eu',
                'PropertyType' => 'Bungalow'
            )
        )
    );
}
