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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS -->
    <link href="{{ asset('css/tailwind.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vuexy/assets/vendor/fonts/fontawesome.css') }}" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('styles')
</head>

<body class="bg-gray-50 font-sans antialiased" x-data="{ sidebarOpen: false, darkMode: false }" :class="{ 'dark': darkMode }" x-cloak>

    @include('components.header')
    @yield('content')




    <!--Image Slider-->
    <script>
        function gallerySlider() {
            const allImages = [
                @foreach ($images as $image)


                    {
                        src: `{{ asset('storage/' . $image->path) }}`,
                        alt: `{{ $image->name }}`
                    },
                @endforeach ()

            ];

            // Bagi menjadi grup 4 gambar
            const groups = [];
            for (let i = 0; i < allImages.length; i += 4) {
                groups.push(allImages.slice(i, i + 4));
            }

            return {
                imageGroups: groups,
                currentSet: 0,
                showModal: false,
                selectedImage: "",
                startSlide() {
                    setInterval(() => {
                        this.currentSet = (this.currentSet + 1) % this.imageGroups.length;
                    }, 5000);
                },
                openImage(src) {
                    this.selectedImage = src;
                    this.showModal = true;
                },
                closeImage() {
                    this.showModal = false;
                    this.selectedImage = "";
                },
            };
        }
    </script>

    <script>
        function popupCards() {
            return {
                showModal: false,
                selectedCard: {},
                cards: [
                    @if (isset($layanans) && $layanans->count() > 0)
                        @foreach ($layanans as $layanan)
                            {
                                title: "{{ $layanan->nama_layanan }}",
                                subtitle: "Layanan Kolam Renang",
                                image: "{{ asset('storage/' . $layanan->gambar) }}",
                                description: `{!! $layanan->deskripsi !!}` // Deskripsi dengan HTML
                            }
                            @if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                    @endif
                ],

                openModal(card) {
                    console.log('Selected card:', card); // Debugging: Log card data
                    this.selectedCard = card;
                    this.showModal = true;
                },

                closeModal() {
                    this.showModal = false;
                },
            };
        }
    </script>

    @stack('scripts')
</body>

</html>
