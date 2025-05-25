<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ config('app.name', 'Sekolah') }}</title>
    
    <!-- Meta Tags -->
    <meta name="description" content="@yield('meta_description', 'Website Resmi Sekolah')">
    <meta name="keywords" content="@yield('meta_keywords', 'sekolah, pendidikan, smk')">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional Styles -->
    @stack('styles')
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
    
    <!-- Footer -->
    @include('layouts.partials.footer')
    
    <!-- Scripts -->
    @stack('scripts')
</body>
</html> 