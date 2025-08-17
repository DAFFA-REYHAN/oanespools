<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title', 'Oanes Pools')</title>

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/x-icon" />

    {{-- Google Fonts (opsional, ini bukan CDN lib JS/CSS) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('vuexy/assets/vendor/fonts/fontawesome.css') }}" />

    {{-- Vite: CSS & JS utama --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
    @stack('scripts')
</head>

{{-- Alpine: state root pakai x-data. Dark mode class toggle --}}

<body class="bg-gray-50 font-sans antialiased" x-data="{ sidebarOpen: false, darkMode: false }" :class="{ 'dark': darkMode }" x-cloak>
    @include('components.header')
    @yield('content')



  
</body>

</html>
