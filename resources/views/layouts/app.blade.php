<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ config('app.name', 'Sekolah') }}</title>

    <!-- Google AdSense -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9955875681226195"
     crossorigin="anonymous"></script>

    <!-- AdSense Overlay -->
    <script>
        window.addEventListener('load', function() {
            setTimeout(function() {
                (adsbygoogle = window.adsbygoogle || []).push({
                    google_ad_client: "ca-pub-9955875681226195",
                    enable_page_level_ads: true,
                    overlays: {bottom: true}
                });
            }, 2000); // Muncul setelah 2 detik
        });
    </script>

    <!-- Basic Meta Tags -->
    <meta name="description" content="@yield('meta_description', 'Website Resmi Sekolah')">
    <meta name="keywords" content="@yield('meta_keywords', 'sekolah, pendidikan, smk')">
    <meta name="author" content="{{ $profil ? $profil->nama_sekolah : config('app.name') }}">
    <meta name="robots" content="index, follow">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('title') - {{ config('app.name', 'Sekolah') }}">
    <meta property="og:description" content="@yield('meta_description', 'Website Resmi Sekolah')">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{ $profil ? $profil->nama_sekolah : config('app.name') }}">
    <meta property="og:locale" content="id_ID">
    @if ($profil && $profil->banner_highlight)
        <meta property="og:image" content="{{ asset('storage/' . $profil->banner_highlight) }}">
        <meta property="og:image:width" content="1920">
        <meta property="og:image:height" content="1080">
        <meta property="og:image:type" content="image/jpeg">
    @endif

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title') - {{ config('app.name', 'Sekolah') }}">
    <meta name="twitter:description" content="@yield('meta_description', 'Website Resmi Sekolah')">
    @if ($profil && $profil->banner_highlight)
        <meta name="twitter:image" content="{{ asset('storage/' . $profil->banner_highlight) }}">
    @endif
    @if ($profil && $profil->twitter)
        <meta name="twitter:site" content="{{ $profil->twitter }}">
    @endif

    <!-- Additional SEO Meta Tags -->
    <meta name="format-detection" content="telephone=no">
    <meta name="theme-color" content="#1e40af">
    <meta name="msapplication-TileColor" content="#1e40af">

    <!-- Geo Location Meta (if available) -->
    @if ($profil && $profil->alamat)
        <meta name="geo.region" content="ID">
        <meta name="geo.placename" content="{{ $profil->kabupaten }}, {{ $profil->provinsi }}">
    @endif

    <!-- Favicon -->
    @php
        $profil = app('profil_sekolah');
    @endphp
    @if ($profil && $profil->favicon)
        <link rel="icon" type="image/x-icon" href="{{ $profil->favicon_url }}">
        <link rel="apple-touch-icon" href="{{ $profil->favicon_url }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
        <link rel="apple-touch-icon" href="{{ asset('favicon.ico') }}">
    @endif

    <!-- Preconnect untuk Performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">



    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional Styles -->
    @stack('styles')

    <!-- Structured Data (JSON-LD) -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "EducationalOrganization",
        "name": "{{ $profil ? $profil->nama_sekolah : config('app.name') }}",
        @if($profil && $profil->alamat)
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "{{ $profil->alamat }}",
            "addressLocality": "{{ $profil->kecamatan }}",
            "addressRegion": "{{ $profil->provinsi }}",
            "postalCode": "{{ $profil->kode_pos }}",
            "addressCountry": "ID"
        },
        @endif
        @if($profil && $profil->email)
        "email": "{{ $profil->email }}",
        @endif
        @if($profil && $profil->no_hp)
        "telephone": "{{ $profil->no_hp }}",
        @endif
        @if($profil && $profil->website)
        "url": "{{ $profil->website }}",
        @endif
        @if($profil && $profil->logo)
        "logo": "{{ asset('storage/' . $profil->logo) }}",
        @endif
        "sameAs": [
            @if($profil && $profil->facebook)"{{ $profil->facebook }}",@endif
            @if($profil && $profil->instagram)"{{ $profil->instagram }}",@endif
            @if($profil && $profil->youtube)"{{ $profil->youtube }}",@endif
            @if($profil && $profil->twitter)"{{ $profil->twitter }}"@endif
        ]
    }
    </script>

    <!-- Additional structured data for specific pages -->
    @stack('structured_data')

</head>

<body class="font-sans antialiased bg-gray-50">
    <!-- Header -->
    @include('layouts.partials.header')

    <!-- Navigation -->
    @include('layouts.partials.navigation')



    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    
    <!-- AdSense Banner Bottom -->
    <div class="w-full bg-white py-2">
        <div class="container mx-auto px-4">
            <ins class="adsbygoogle"
                style="display:block"
                data-ad-client="ca-pub-9955875681226195"
                data-ad-slot="YOUR_AD_SLOT_ID"
                data-ad-format="auto"
                data-full-width-responsive="true"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
    </div>

    <!-- Footer -->
    @include('layouts.partials.footer')

    <!-- Scripts -->
    @stack('scripts')
</body>

</html>
