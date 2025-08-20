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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('vuexy/assets/vendor/fonts/fontawesome.css') }}" />

    <!-- Ini Fancybox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" />

    <style>
        body {
            scroll-behavior: smooth;
        }
    </style>

    {{-- Vite: CSS & JS utama --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
    @stack('scripts')
</head>

{{-- Alpine: state root pakai x-data. Dark mode class toggle --}}

<body class="bg-gray-50 font-sans antialiased" x-data="{ sidebarOpen: false, darkMode: false }" :class="{ 'dark': darkMode }" x-cloak>
    @include('components.header')
    @yield('content')

    <!-- Tombol untuk Scroll Up -->
    <button x-data="{ showButton: false, isBottom: false }" x-show="showButton" x-cloak
        x-on:click="window.scrollTo({ top: 0, behavior: 'smooth' })" x-init="window.addEventListener('scroll', () => {
            const scrollPosition = document.documentElement.scrollTop || document.body.scrollTop;
            const maxScroll = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            showButton = scrollPosition > 100; // Tombol muncul setelah scroll lebih dari 100px
            isBottom = scrollPosition === maxScroll; // Mengecek apakah sudah di bagian bawah
        })"
        :class="isBottom ? 'bottom-24' : 'bottom-4'"
        class="fixed right-4 bg-blue-500 text-white p-5 rounded-full shadow-lg hover:bg-blue-700 transition duration-300">
        <i class="iconbase fa-solid fa-arrow-up"></i>
    </button>

</body>

</html>
