@php
    $seoConfig = config('seo');
    $seoRoute = $seoConfig['pages'][\Illuminate\Support\Facades\Route::currentRouteName()] ?? $seoConfig['pages']['home'];

    $seoSiteName = $seoConfig['site_name'];
    $seoSiteUrl = $seoConfig['site_url'];
    $seoTitle = $seoRoute['title'];
    $seoDescription = $seoRoute['description'];
    $seoKeywords = $seoRoute['keywords'] ?? null;
    $seoCanonical = $seoSiteUrl . $seoRoute['path'];
    $seoImage = $seoSiteUrl . $seoConfig['default_image'];

    $seoOrganizationJsonLd = [
        '@context' => 'https://schema.org',
        '@type' => 'FinancialService',
        'name' => $seoConfig['organization']['name'],
        'legalName' => $seoConfig['organization']['legal_name'],
        'description' => $seoConfig['organization']['description'],
        'url' => $seoSiteUrl,
        'logo' => $seoImage,
        'image' => $seoImage,
        'email' => $seoConfig['organization']['email'],
        'telephone' => $seoConfig['organization']['telephone'],
        'address' => [
            '@type' => 'PostalAddress',
            ...$seoConfig['organization']['address'],
        ],
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
        <meta property="og:locale" content="{{ $seoConfig['locale'] }}">
        <meta property="og:title" content="{{ $seoTitle }}">
        <meta property="og:description" content="{{ $seoDescription }}">
        <meta property="og:url" content="{{ $seoCanonical }}">
        <meta property="og:image" content="{{ $seoImage }}">
        <meta property="og:image:width" content="{{ $seoConfig['default_image_width'] }}">
        <meta property="og:image:height" content="{{ $seoConfig['default_image_height'] }}">

        <!-- Twitter / X -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $seoTitle }}">
        <meta name="twitter:description" content="{{ $seoDescription }}">
        <meta name="twitter:image" content="{{ $seoImage }}">

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
