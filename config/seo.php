<?php

/**
 * Configuración central de SEO / previsualizaciones (Open Graph, Twitter Card,
 * JSON-LD) para el sitio público.
 *
 * Estos valores se usan en resources/views/app.blade.php para renderizar las
 * etiquetas <title>, <meta description>, canonical, og:*, twitter:* y los
 * bloques JSON-LD directamente en el HTML que devuelve el servidor (sin
 * depender de que se ejecute JavaScript), para que:
 *
 *  - Bots que NO ejecutan JS (Facebook, WhatsApp, Twitter/X, LinkedIn) puedan
 *    generar la previsualización del link correctamente.
 *  - Google/Bing vean el título, descripción y datos estructurados desde la
 *    primera respuesta HTML.
 *
 * Cada página Vue conserva únicamente un <title> propio (para que el título
 * de la pestaña se actualice también en la navegación SPA de Inertia).
 */

return [

    // Nombre de marca usado en og:site_name y como sufijo de <title>.
    'site_name' => 'Mr. Lana',

    // Dominio público (sin slash final). Puede sobreescribirse con
    // SEO_SITE_URL en .env si el dominio cambia.
    'site_url' => rtrim(env('SEO_SITE_URL', 'https://mr-lana.com'), '/'),

    // Locale para og:locale.
    'locale' => 'es_MX',

    // Imagen usada como og:image / twitter:image cuando la página no define
    // una propia. Ruta relativa a /public.
    'default_image' => '/img/logo-mr-lana.png',
    'default_image_width' => 508,
    'default_image_height' => 192,

    // Datos de la organización para el JSON-LD (schema.org/FinancialService)
    // que se imprime en todas las páginas.
    'organization' => [
        'legal_name' => 'Productos y Servicios Mr. Lana S.A.P.I. de C.V.',
        'name' => 'Mr. Lana',
        'description' => 'Entidad financiera mexicana de nano y microcréditos para negocios, empleados y emprendedores.',
        'email' => 'atencionclientes@mr-lana.com',
        'telephone' => '+52-777-422-5973',
        'address' => [
            'streetAddress' => 'Subida del Club 114, Zona 1, Reforma',
            'addressLocality' => 'Cuernavaca',
            'addressRegion' => 'Morelos',
            'postalCode' => '62270',
            'addressCountry' => 'MX',
        ],
    ],

    // Metadatos por ruta con nombre (Route::currentRouteName()). La entrada
    // "home" también se usa como fallback si la ruta actual no está mapeada.
    'pages' => [

        'home' => [
            'path' => '/',
            'title' => 'Mr. Lana | Créditos rápidos y accesibles en México',
            'description' => 'Mr. Lana ofrece créditos rápidos, claros y accesibles para negocios, empleados y emprendedores en México. Solicita hoy y recibe respuesta en minutos.',
            'keywords' => 'mr lana, créditos rápidos, préstamos en méxico, microcréditos, nano créditos, crédito semanal',
        ],

        'impulsaNegocio' => [
            'path' => '/impulsa-tu-negocio',
            'title' => 'Impulsa tu Negocio | Mr. Lana',
            'description' => 'Impulsa tu Negocio con los créditos semanales de Mr. Lana. Opciones flexibles para dueños de negocios establecidos que buscan crecer.',
            'keywords' => 'créditos para negocios, crédito semanal, préstamo para negocio, impulsa tu negocio, financiamiento pymes méxico',
        ],

        'impulsat' => [
            'path' => '/impulsat',
            'title' => 'Impulsa.t | Mr. Lana',
            'description' => 'Impulsa.t de Mr. Lana: crédito semanal fácil y rápido para empleados y trabajadores formales. Solicita hoy y recibe respuesta en minutos.',
            'keywords' => 'crédito semanal, crédito para empleados, préstamo rápido, impulsa.t, mr lana crédito',
        ],

        'sucursales' => [
            'path' => '/sucursales',
            'title' => 'Sucursales | Mr. Lana',
            'description' => 'Consulta las sucursales de Mr. Lana por estado: teléfono directo y ubicación en Google Maps.',
            'keywords' => 'sucursales mr lana, oficinas mr lana, direcciones mr lana méxico',
        ],

        'faqs' => [
            'path' => '/faqs',
            'title' => 'Preguntas frecuentes | Mr. Lana',
            'description' => 'Resuelve tus dudas sobre créditos, solicitudes y servicios de Mr. Lana. Consulta nuestras preguntas frecuentes o envíanos tu pregunta.',
            'keywords' => 'faq mr lana, preguntas frecuentes créditos, dudas préstamos, ayuda mr lana, soporte crédito',
        ],

        'avisoPrivacidad' => [
            'path' => '/aviso-de-privacidad',
            'title' => 'Aviso de Privacidad | Mr. Lana',
            'description' => 'Aviso de Privacidad de Mr. Lana. Conoce cómo se recaban y tratan tus datos personales, derechos ARCO, transferencias y medios de contacto.',
            'keywords' => 'aviso de privacidad mr lana, protección de datos personales, derechos arco',
        ],

        'Terminos' => [
            'path' => '/terminos-y-condiciones',
            'title' => 'Términos y Condiciones | Mr. Lana',
            'description' => 'Términos y Condiciones de Mr. Lana. Consulta las reglas de uso de la aplicación móvil y el sitio web, y el alcance de nuestros servicios.',
            'keywords' => 'términos y condiciones mr lana, condiciones de uso, mr lana app',
        ],

        'nosotros' => [
            'path' => '/nosotros',
            'title' => '¿Quiénes somos? | Mr. Lana',
            'description' => 'Conoce quiénes somos en Mr. Lana. Somos una entidad financiera mexicana de nano y microcréditos enfocada en impulsar negocios y proyectos productivos.',
            'keywords' => 'mr lana, quienes somos, microcréditos méxico, nano créditos, entidad financiera mexicana, misión visión mr lana',
        ],

        'creditoComadres' => [
            'path' => '/credito-comadres',
            'title' => 'Crédito Comadres | Mr. Lana',
            'description' => 'Crédito Comadres de Mr. Lana: préstamos grupales para mujeres emprendedoras. Forma tu grupo, obtén financiamiento y haz crecer tu negocio.',
            'keywords' => 'crédito para mujeres, crédito grupal, crédito comadres, préstamos para emprendedoras, microcréditos méxico',
        ],

    ],

];
