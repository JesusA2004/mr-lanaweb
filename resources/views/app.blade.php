@php
    // Fallback defensivo: si en el servidor el config todavía está cacheado
    // (php artisan config:cache) desde antes de que existiera config/seo.php,
    // config('seo') puede devolver null. En ese caso no debe tronar la página,
    // solo perder el SEO enriquecido hasta que se limpie la caché de config.
    $seoConfig = config('seo') ?? [];
    $seoPages = $seoConfig['pages'] ?? [];
    $seoHome = $seoPages['home'] ?? [
        'path' => '/',
        'title' => config('app.name', 'Mr. Lana'),
        'description' => '',
    ];
    $seoRoute = $seoPages[\Illuminate\Support\Facades\Route::currentRouteName()] ?? $seoHome;
    $seoOrganization = $seoConfig['organization'] ?? [];
    $seoOrgAddress = $seoOrganization['address'] ?? [];

    $seoSiteName = $seoConfig['site_name'] ?? config('app.name', 'Mr. Lana');
    $seoSiteUrl = $seoConfig['site_url'] ?? config('app.url', '');
    $seoTitle = $seoRoute['title'] ?? $seoSiteName;
    $seoDescription = $seoRoute['description'] ?? '';
    $seoKeywords = $seoRoute['keywords'] ?? null;
    $seoCanonical = $seoSiteUrl . ($seoRoute['path'] ?? '/');
    $seoImage = $seoSiteUrl . ($seoConfig['default_image'] ?? '/img/logo-mr-lana.png');
    $seoImageAlt = $seoConfig['default_image_alt'] ?? $seoSiteName;

    $seoOrganizationJsonLd = [
        '@context' => 'https://schema.org',
        '@type' => 'FinancialService',
        'name' => $seoOrganization['name'] ?? $seoSiteName,
        'legalName' => $seoOrganization['legal_name'] ?? $seoSiteName,
        'description' => $seoOrganization['description'] ?? $seoDescription,
        'url' => $seoSiteUrl,
        'logo' => $seoImage,
        'image' => $seoImage,
        'email' => $seoOrganization['email'] ?? null,
        'telephone' => $seoOrganization['telephone'] ?? null,
        // array_merge en vez de "...$array" (spread con claves string):
        // ese spread requiere PHP 8.1+ y tronaba en producción.
        'address' => array_merge(['@type' => 'PostalAddress'], $seoOrgAddress),
        'areaServed' => 'MX',
    ];

    $seoPageJsonLd = [
        '@context' => 'https://schema.org',
        '@type' => 'WebPage',
        'name' => $seoTitle,
        'description' => $seoDescription,
        'url' => $seoCanonical,
        'inLanguage' => 'es-MX',
        'isPartOf' => [
            '@type' => 'WebSite',
            'name' => $seoSiteName,
            'url' => $seoSiteUrl,
        ],
    ];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  @class(['dark' => ($appearance ?? 'system') == 'dark'])>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title inertia>{{ $seoTitle }}</title>

        <!-- SEO básico -->
        <meta name="description" content="{{ $seoDescription }}">
        @if($seoKeywords)
        <meta name="keywords" content="{{ $seoKeywords }}">
        @endif
        <meta name="robots" content="index, follow">
        <link rel="canonical" href="{{ $seoCanonical }}">

        <!-- Open Graph (Facebook, WhatsApp, LinkedIn) -->
        <meta property="og:type" content="website">
        <meta property="og:site_name" content="{{ $seoSiteName }}">
        <meta property="og:locale" content="{{ $seoConfig['locale'] ?? 'es_MX' }}">
        <meta property="og:title" content="{{ $seoTitle }}">
        <meta property="og:description" content="{{ $seoDescription }}">
        <meta property="og:url" content="{{ $seoCanonical }}">
        <meta property="og:image" content="{{ $seoImage }}">
        <meta property="og:image:width" content="{{ $seoConfig['default_image_width'] ?? 1200 }}">
        <meta property="og:image:height" content="{{ $seoConfig['default_image_height'] ?? 630 }}">
        <meta property="og:image:alt" content="{{ $seoImageAlt }}">

        <!-- Twitter / X -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $seoTitle }}">
        <meta name="twitter:description" content="{{ $seoDescription }}">
        <meta name="twitter:image" content="{{ $seoImage }}">
        <meta name="twitter:image:alt" content="{{ $seoImageAlt }}">

        <!-- JSON-LD -->
        <script type="application/ld+json">{!! json_encode($seoOrganizationJsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
        <script type="application/ld+json">{!! json_encode($seoPageJsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @vite(['resources/js/app.ts', "resources/js/pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
