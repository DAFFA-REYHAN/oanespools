
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Oanes Pools') </title>


    <!-- Favicon (Logo in Browser Title) -->
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">



    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <link href="{{ asset('css/tailwind.min.css') }}" rel="stylesheet">

    @if (app()->environment('local'))
        {{-- Development: Load Tailwind CSS from CDN --}}
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        colors: {
                            primary: {
                                50: '#f0f9ff',
                                100: '#e0f2fe',
                                200: '#bae6fd',
                                300: '#7dd3fc',
                                400: '#38bdf8',
                                500: '#0ea5e9',
                                600: '#0284c7',
                                700: '#0369a1',
                                800: '#075985',
                                900: '#0c4a6e',
                            },
                            vuexy: {
                                50: '#f3f1ff',
                                100: '#ebe5ff',
                                200: '#d9ceff',
                                300: '#bea6ff',
                                400: '#9f75ff',
                                500: '#8b5cf6',
                                600: '#7c3aed',
                                700: '#6d28d9',
                                800: '#5b21b6',
                                900: '#4c1d95',
                            }
                        },
                        fontFamily: {
                            sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                        },
                    }
                }
            }
        </script>
    @else
        {{-- Production: Use locally compiled Tailwind CSS --}}
        <link href="{{ asset('css/tailwind.min.css') }}" rel="stylesheet">
    @endif

    <!-- Custom Styles -->
    <style>
        [x-cloak] {
            display: none !important;
        }

        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.8);
        }

        .sidebar-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>

    @stack('styles')
</head>

<body class="bg-gray-50 font-sans antialiased" x-data="{ sidebarOpen: false, darkMode: false }" :class="{ 'dark': darkMode }" x-cloak>

    @include('components.header')
    @yield('content')

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('scripts')
</body>
</html>
