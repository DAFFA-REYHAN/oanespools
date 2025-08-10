<!doctype html>
<html lang="en" class="layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr" data-skin="default"
    data-bs-theme="light" data-assets-path="../vuexy/assets/" data-template="vertical-menu-template-starter">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />

    <title>@yield('title', 'Oanes Pools') </title>

    <!-- Favicon (Logo in Browser Title) -->
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">

    <meta name="description" content="" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('vuexy/assets/vendor/fonts/iconify-icons.css') }}" />

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css  -->
    <link rel="stylesheet" href="{{ asset('vuexy/assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('vuexy/assets/vendor/libs/pickr/pickr-themes.css') }}" />
    <link rel="stylesheet" href="{{ asset('vuexy/assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('vuexy/assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('vuexy/assets/vendor/fonts/fontawesome.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('vuexy/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- endbuild -->

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('vuexy/assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <script src="{{ asset('vuexy/assets/vendor/js/template-customizer.js') }}"></script>

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('vuexy/assets/js/config.js') }}"></script>

    @yield('css')

    <style>
        .text-container-text {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
            /* You can use any value you need */
        }

        .text-container-header {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
            /* You can use any value you need */
        }

        /* Custom CSS for image height control */
        @media (max-width: 768px) {
            .card-img-left {
                max-height: 200px;
                /* Adjust the height on smaller screens */
            }
        }

        @media (min-width: 768px) {
            .card-img-left {
                max-height: 200px;
                /* Larger height for medium and large screens */
            }
        }
    </style>

</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu">
                <div class="app-brand demo ms-0 ps-0">
                    <a href="#" class="app-brand-link">
                        <span class="app-brand-logo demo">
                            <img src="{{ asset('img/logo.png') }}" height="60px" />
                        </span>
                        </span>
                        <span class="fw-bold text-blue fst-italic fs-3">Oanes Pools</span>
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                        <i class="icon-base ti menu-toggle-icon d-none d-xl-block"></i>
                        <i class="icon-base ti tabler-x d-block d-xl-none"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- Page -->
                    <li class="menu-item {{ Route::is('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}" class="menu-link">
                            <i class="menu-icon icon-base ti tabler-buildings"></i>
                            <div data-i18n="Jumlah Proyek & Pelanggan">Jumlah Proyek & Pelanggan</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Route::is('layanan') ? 'active' : '' }}">
                        <a href="{{ route('layanan') }}" class="menu-link">
                            <i class="menu-icon icon-base fa-solid fa-person-swimming"></i>
                            <div data-i18n="Page 2">Layanan</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('layanan') }}" class="menu-link">
                            <i class="menu-icon icon-base fa-solid fa-images"></i>
                            <div data-i18n="Page 2">Galeri</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('layanan') }}" class="menu-link">
                            <i class="menu-icon icon-base fa-regular fa-newspaper"></i>
                            <div data-i18n="Page 2">Artikel</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('layanan') }}" class="menu-link">
                            <i class="menu-icon icon-base fa-regular fa-star"></i>
                            <div data-i18n="Page 2">Penilaian</div>
                        </a>
                    </li>
                </ul>
            </aside>

            <div class="menu-mobile-toggler d-xl-none rounded-1">
                <a href="javascript:void(0);"
                    class="layout-menu-toggle menu-link text-large text-bg-secondary p-2 rounded-1">
                    <i class="ti tabler-menu icon-base"></i>
                    <i class="ti tabler-chevron-right icon-base"></i>
                </a>
            </div>
            <!-- / Menu -->

            @yield('content')
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/theme.js  -->

    <script src="{{ asset('vuexy/assets/vendor/libs/jquery/jquery.js') }}"></script>

    <script src="{{ asset('vuexy/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('vuexy/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('vuexy/assets/vendor/libs/node-waves/node-waves.js') }}"></script>

    <script src="{{ asset('vuexy/assets/vendor/libs/@algolia/autocomplete-js.js') }}"></script>

    <script src="{{ asset('vuexy/assets/vendor/libs/pickr/pickr.js') }}"></script>

    <script src="{{ asset('vuexy/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('vuexy/assets/vendor/libs/hammer/hammer.js') }}"></script>

    <script src="{{ asset('vuexy/assets/vendor/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->

    <script src="{{ asset('vuexy/assets/js/main.js') }}"></script>

    <!-- Page JS -->

    @yield('js')
</body>

</html>
