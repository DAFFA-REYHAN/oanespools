@extends('app')

@section('title', 'Oanes Pools')

@push('styles')
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .prose h1,
        .prose h2,
        .prose h3,
        .prose h4,
        .prose h5,
        .prose h6 {
            margin-top: 1.5em;
            margin-bottom: 0.5em;
            font-weight: 600;
        }

        .prose p {
            margin-bottom: 1em;
        }

        .prose ul,
        .prose ol {
            margin: 1em 0;
            padding-left: 1.5em;
        }

        .prose img {
            margin: 1.5em 0;
            border-radius: 0.5rem;
        }

        /* Slider Styles */
        .swiper-container {
            position: relative;
            overflow: hidden;
            height: 100%;
        }

        .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Fancybox Styles */
        .fancybox-content {
            background-color: #fff;
            border-radius: 10px;
            max-width: 80vw;
            max-height: 80vh;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #444;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .truncate-lines {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            /* Membatasi menjadi 3 baris */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;

        }

        .truncate-lines-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            /* Membatasi menjadi 3 baris */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;

        }
    </style>

    </style>
@endpush

@section('content')

    {{-- HERO --}}
    <section class="relative">

        <!-- NAVBAR -->
        <nav class="absolute top-0 left-0 w-full flex justify-between items-center p-6 z-20">
            <div class="flex items-center space-x-2">
                <img src="img/logo.png" alt="Logo Oanes Pools" class="h-16 w-20" />
                <span class="text-white font-bold text-2xl italic">Oanes Pools</span>
            </div>
            @auth
                <a hidden href="{{ route('dashboard') }}"
                    class="inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    Dashboard
                </a>
            @endauth
            <a href="https://wa.me/6281291100645" target="_blank"
                class="font-semibold w-max px-5 py-3 border border-white text-white rounded-full text-sm hover:bg-white hover:text-black transition">
                Hubungi Kami
            </a>
        </nav>

        <!-- HEADER -->
        <div class="relative bg-cover bg-center overflow-hidden h-[90vh]" style="background-image: url('img/header.jpg');">
            <!-- OVERLAY -->
            <div class="absolute inset-0 bg-black/50"></div>

            <!-- CONTENT -->
            <div class="absolute inset-0 flex flex-col justify-center px-4 sm:px-8 lg:px-8 text-white z-10">
                <span class="text-sm sm:text-base lg:text-lg mb-2">#1 ahli kolam renang</span>
                <h1 class="text-4xl sm:text-6xl lg:text-7xl font-bold max-w-full leading-tight">
                    Solusi Lengkap <br />
                    Kolam Renang Anda
                </h1>
            </div>

            <!-- SUMMARY -->
            <div
                class="absolute right-0 bottom-0 bg-gray-50 shadow-lg rounded-tl-2xl sm:rounded-tl-3xl
                    p-6 sm:p-10 lg:p-14 grid grid-cols-2 gap-6 sm:gap-12 lg:gap-16 z-10
                    w-full sm:w-auto">
                <div class="text-center">
                    <p class="text-3xl sm:text-4xl lg:text-5xl font-bold text-blue-700">{{ $hero->jumlah_proyek ?? 0 }}+</p>
                    <p class="text-gray-500 text-xs sm:text-sm lg:text-base">Proyek Selesai</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl sm:text-4xl lg:text-5xl font-bold text-blue-700">{{ $hero->jumlah_pelanggan ?? 0 }}+
                    </p>
                    <p class="text-gray-500 text-xs sm:text-sm lg:text-base">Pelanggan</p>
                </div>
            </div>
        </div>
    </section>
    {{-- END HERO --}}

    {{-- SERVICES --}}
    @php
        $cards = isset($layanans)
            ? $layanans->take(6)->map(
                // ini gua buat batas nya 6 aja ya nyoh
                fn($l) => [
                    'title' => $l->nama_layanan,
                    'subtitle' => 'Layanan Kolam Renang',
                    'image' => asset('storage/' . $l->gambar),
                    'description' => $l->deskripsi, // HTML
                ],
            )
            : collect([]);
    @endphp
    <section class="pt-20 sm:pt-28 lg:pt-40" x-data="popupCards({{ Js::from($cards) }})">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-12 gap-8">
                <h2 class="text-3xl sm:text-4xl font-bold text-center md:text-left max-w-xl">
                    Kami Melayani Beragam <br />
                    Kebutuhan Anda
                </h2>
                <p class="text-gray-500 text-justify md:text-left font-medium text-base max-w-xl">
                    Apapun kebutuhan kolam renang Anda, kami punya solusinya. Kami
                    menyediakan layanan terpadu untuk pembangunan, perbaikan, dan
                    perawatan kolam renang.
                </p>
            </div>

            <!-- CARD CONTENT -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="(card, index) in cards" :key="index">
                    <div class="relative rounded-2xl overflow-hidden shadow-lg group cursor-pointer"
                        @click="openModal(card)">
                        <img :src="card.image" :alt="card.title"
                            class="w-full h-56 sm:h-72 lg:h-80 object-cover group-hover:scale-105 transition" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                        <div class="absolute bottom-4 left-4 text-white">
                            <h3 class="text-lg sm:text-xl font-semibold" x-text="card.title"></h3>
                            {{-- <p class="text-sm sm:text-base" x-text="card.subtitle"></p> --}}
                        </div>
                    </div>
                </template>
            </div>

            <!-- MODAL -->
            <div x-show="showModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4"
                @click.self="closeModal()">
                <div class="bg-white rounded-lg w-full max-w-md sm:max-w-lg lg:max-w-xl overflow-hidden shadow-lg">
                    <img :src="selectedCard.image" class="w-full h-48 sm:h-56 lg:h-64 object-cover" />
                    <div class="p-4 sm:p-6">
                        <h3 class="text-xl sm:text-2xl font-semibold mb-2" x-text="selectedCard.title"></h3>
                        <div class="text-gray-600 text-sm sm:text-base mb-4" x-html="selectedCard.description"></div>
                        <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 w-full sm:w-auto"
                            @click="closeModal()">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- END SERVICES --}}

    {{-- WHY CHOOSE US --}}
    <section class="pt-20 sm:pt-28 lg:pt-40">
        <div class="bg-gradient-to-b from-[#0a1436] via-black to-black text-white py-16">
            <div class="max-w-7xl mx-auto">
                <!-- Header -->
                <div class="flex flex-col md:flex-row justify-between items-center mb-12 gap-8">
                    <h2 class="text-3xl sm:text-4xl font-bold text-center md:text-left max-w-xl">
                        Kenapa Anda Harus <br />
                        Memilih Kami?
                    </h2>
                    <p class="text-gray-200 text-justify md:text-left font-medium text-base max-w-xl">
                        Kami hadir untuk memberikan lebih dari sekadar layanan, kami hadir untuk menawarkan solusi lengkap
                        yang
                        didukung
                        oleh pengalaman, kualitas bahan terbaik, dan tim profesional.
                    </p>
                </div>

                <!-- Grid Content -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-8">

                    <!-- Item -->
                    <div class="flex flex-col gap-4 bg-white/10 rounded-2xl p-6 border border-white/10">
                        <div class="bg-white/15 p-3 rounded-lg text-white w-max">
                            <!-- Icon 1 -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2">
                                    <path d="M1 20v-1a7 7 0 0 1 7-7v0a7 7 0 0 1 7 7v1" />
                                    <path d="M13 14v0a5 5 0 0 1 5-5v0a5 5 0 0 1 5 5v.5" />
                                    <path stroke-linejoin="round"
                                        d="M8 12a4 4 0 1 0 0-8a4 4 0 0 0 0 8m10-3a3 3 0 1 0 0-6a3 3 0 0 0 0 6" />
                                </g>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold mb-2">Tim Profesional</h3>
                            <p class="text-gray-300 text-base leading-relaxed">
                                Didukung oleh tim ahli yang berpengalaman dan bersertifikat,
                                kami menjamin setiap pengerjaan kolam renang dilakukan dengan
                                standar tertinggi.
                            </p>
                        </div>
                    </div>

                    <!-- Item -->
                    <div class="flex flex-col gap-4 bg-white/10 rounded-2xl p-6 border border-white/10">
                        <div class="bg-white/15 p-3 rounded-lg text-white w-max">
                            <!-- Icon 2 -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2">
                                    <path d="M2 22h11a9 9 0 1 0 0-18c-4.633 0-8.503 3.5-9 8m14.5-6.5l1-1m-14 0l1 1" />
                                    <path
                                        d="m16.5 9l-2.94 2.94m0 0a1.5 1.5 0 1 0-2.121 2.121a1.5 1.5 0 0 0 2.122-2.122M12.5 3.5V2m-2 0h4M2 15h3m-3 4h5" />
                                </g>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold mb-2">Cepat dan Akurat</h3>
                            <p class="text-gray-300 text-base leading-relaxed">
                                Dengan manajemen proyek yang efisien, kami memastikan setiap
                                pekerjaan selesai tepat waktu sesuai dengan jadwal yang telah
                                disepakati.
                            </p>
                        </div>
                    </div>

                    <!-- Item -->
                    <div class="flex flex-col gap-4 bg-white/10 rounded-2xl p-6 border border-white/10">
                        <div class="bg-white/15 p-3 rounded-lg text-white w-max">
                            <!-- Icon 3 -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2">
                                    <path stroke-linejoin="round"
                                        d="M2.75 12H6a2 2 0 0 1 2 2a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2a2 2 0 0 1 2-2h3.25" />
                                    <path
                                        d="M21.25 10.375v4.875a6 6 0 0 1-6 6h-6.5a6 6 0 0 1-6-6v-6.5a6 6 0 0 1 6-6h4.875" />
                                    <path stroke-linejoin="round"
                                        d="m16.25 5.582l1.407 1.407a.53.53 0 0 0 .757 0l2.836-2.836" />
                                </g>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold mb-2">Bahan Berkualitas</h3>
                            <p class="text-gray-300 text-base leading-relaxed">
                                Kualitas kolam renang dimulai dari bahan baku. Kami hanya
                                menggunakan bahan-bahan terbaik dan teruji yang tahan lama serta
                                aman, sehingga kolam renang indah, kokoh dan awet.
                            </p>
                        </div>
                    </div>

                    <!-- Item -->
                    <div class="flex flex-col gap-4 bg-white/10 rounded-2xl p-6 border border-white/10">
                        <div class="bg-white/15 p-3 rounded-lg text-white w-max">
                            <!-- Icon 4 -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.8">
                                    <path d="M19.745 13a7 7 0 1 0-12.072-1" />
                                    <path
                                        d="M14 6c-1.105 0-2 .672-2 1.5S12.895 9 14 9s2 .672 2 1.5s-.895 1.5-2 1.5m0-6c.87 0 1.612.417 1.886 1M14 6V5m0 7c-.87 0-1.612-.417-1.886-1M14 12v1M3 14h2.395c.294 0 .584.066.847.194l2.042.988c.263.127.553.193.848.193h1.042c1.008 0 1.826.791 1.826 1.767c0 .04-.027.074-.066.085l-2.541.703a1.95 1.95 0 0 1-1.368-.124L5.842 16.75M12 16.5l4.593-1.411a1.985 1.985 0 0 1 2.204.753c.369.51.219 1.242-.319 1.552l-7.515 4.337a2 2 0 0 1-1.568.187L3 20.02" />
                                </g>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold mb-2">Harga Bersahabat</h3>
                            <p class="text-gray-300 text-base leading-relaxed">
                                Kami memahami bahwa kualitas tidak harus mahal. Dengan harga
                                yang transparan dan kompetitif, kami memastikan Anda mendapatkan
                                layanan terbaik tanpa harus menguras anggaran.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    {{-- END WHY CHOOSE US --}}

    {{-- GALLERY --}}
    @php
        // Data gambar
        $imageData = $images->map(
            fn($img) => [
                'src' => asset('storage/' . $img->path),
                'alt' => $img->name,
            ],
        );

        // Data video
        $videoItems = $videos->filter(fn($g) => $g->type === 'video' && $g->is_youtube)->map(function ($g) {
            return (object) [
                'title' => $g->name ?? 'Video',
                'href' => $g->full_url,
                'thumb' => $g->thumbnail_url ?? asset('img/placeholder-video.jpg'),
            ];
        });
    @endphp
    <section class="px-4 sm:px-6 pt-20 sm:pt-28 lg:pt-40">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-12 gap-8">
                <h2 class="text-3xl sm:text-4xl font-bold text-center md:text-left max-w-xl">
                    Intip Pekerjaan Hebat Kami <br />
                    Dari Tangan Ahli
                </h2>
                <p class="text-gray-500 text-justify md:text-left font-medium text-base max-w-xl">
                    Lihatlah sendiri bukti dari keahlian kami. Dalam galeri ini,
                    berbagai proyek kolam renang yang telah kami selesaikan,
                    mulai dari desain modern hingga renovasi yang mengagumkan.
                </p>
            </div>

            {{-- =================== VIDEO SLIDER =================== --}}
            @if ($videoItems->isNotEmpty())
                <div class="relative mb-10 rounded-2xl overflow-hidden w-full max-w-5xl mx-auto">
                    <div class="mySwiper js-video-swiper">
                        <div class="swiper-wrapper">
                            @foreach ($videoItems as $it)
                                <div class="swiper-slide">
                                    <a data-fancybox="videos" href="{{ $it->href }}"
                                        data-caption="{{ $it->title }}"
                                        class="block relative rounded-2xl cursor-pointer overflow-hidden">
                                        <div class="relative pt-[56.25%] bg-black">
                                            <img src="{{ $it->thumb }}" alt="{{ $it->title }}"
                                                class="absolute inset-0 w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                                                loading="lazy" />

                                            <!-- Play Button -->
                                            <div class="absolute inset-0 flex items-center justify-center">
                                                <div class="bg-white/80 rounded-full p-3 sm:p-4 backdrop-blur-sm">
                                                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-black" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M6.5 5.5a1 1 0 011.538-.843l6 4a1 1 0 010 1.686l-6 4A1 1 0 016.5 13.5v-8z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <p class="text-center text-gray-500 mb-10">📹 Data video belum ada</p>
            @endif

            {{-- =================== IMAGE SLIDER =================== --}}
            @if ($imageData->isNotEmpty())
                <section class="px-0 sm:px-6" x-data="gallerySlider({{ Js::from($imageData) }})" x-init="startSlide()">
                    <div class="max-w-7xl mx-auto">
                        <!-- Slide Container -->
                        <div class="relative overflow-hidden h-40 sm:h-56 md:h-64 lg:h-72">
                            <template x-for="(group, groupIndex) in imageGroups" :key="groupIndex">
                                <div class="absolute top-0 left-0 w-full grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2 sm:gap-4 transition-transform duration-700 ease-in-out"
                                    :class="{
                                        'translate-x-0': currentSet === groupIndex,
                                        '-translate-x-full': currentSet !== groupIndex && groupIndex < currentSet,
                                        'translate-x-full': currentSet !== groupIndex && groupIndex > currentSet
                                    }">
                                    <template x-for="(image, index) in group" :key="index">
                                        <!-- Trigger Fancybox -->
                                        <a data-fancybox="gallery" :href="image.src" :data-caption="image.alt"
                                            class="cursor-pointer">
                                            <img :src="image.src" :alt="image.alt"
                                                class="rounded-xl object-cover w-full h-40 sm:h-56 md:h-64 lg:h-72" />
                                        </a>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                </section>
            @else
                <p class="text-center text-gray-500 mt-10">🖼️ Data gambar belum ada</p>
            @endif

            <!-- Fancybox JS -->
            <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
            <script>
                Fancybox.bind("[data-fancybox='gallery']", {
                    Thumbs: {
                        autoStart: true
                    },
                    Toolbar: {
                        display: ["zoom", "close"]
                    },
                });
            </script>
        </div>
    </section>
    {{-- END GALLERY --}}

    {{-- TESTIMONI --}}
    <section class="pt-20 sm:pt-28 lg:pt-40">
        <div x-data="{
            current: 0,
            total: Math.ceil({{ count($testimonis) }} / 2)
        }">
            <div class="bg-gradient-to-b from-[#0a1436] via-black to-black text-white py-16">
                <div class="max-w-7xl mx-auto">

                    <!-- Heading -->
                    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-12">

                        <div class="md:w-1/2">
                            <h2 class="text-3xl sm:text-4xl font-bold mb-4">
                                Kata Mereka Tentang <br />Pekerjaan Kami
                            </h2>
                        </div>
                        <p class="text-gray-200 text-justify font-medium text-md max-w-xl">
                            Kepuasan Anda adalah prioritas kami. Baca langsung pengalaman dan
                            testimoni dari para pelanggan yang telah mempercayakan proyek
                            kolam renangnya kepada kami.
                        </p>
                    </div>

                    <!-- Testimonials Slider -->
                    @if ($testimonis->isNotEmpty())
                        <div class="overflow-hidden relative">
                            <div class="flex transition-transform duration-700 ease-in-out"
                                :style="`transform: translateX(-${current * 100}%)`">

                                @foreach ($testimonis as $testi)
                                    <div class="w-full md:w-1/2 flex-shrink-0 px-3">
                                        <div class="bg-white/10 rounded-2xl p-10 border border-white/10">
                                            <p class="text-gray-300 text-lg mb-4">
                                                {{ $testi->pesan }}
                                            </p>
                                            <div>
                                                <p class="font-semibold text-lg text-white">{{ $testi->nama }}</p>
                                                <p class="text-gray-300">{{ $testi->domisili }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    @else
                        <p class="text-center text-gray-500">Belum ada testimoni.</p>
                    @endif

                    <!-- Arrows -->
                    <div class="flex justify-center mt-10 gap-4" x-show="total > 1">
                        <button @click="current = current > 0 ? current - 1 : 0"
                            class="w-10 h-10 rounded-full border flex items-center justify-center hover:bg-gray-100 transition"
                            aria-label="Sebelumnya">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button @click="current = current + 1 < total ? current + 1 : current"
                            class="w-10 h-10 rounded-full border flex items-center justify-center hover:bg-gray-100 transition"
                            aria-label="Selanjutnya">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>

                </div>
            </div>
    </section>

    {{-- ARTICLE --}}
    <section class="px-4 sm:px-6 pt-20 sm:pt-28 lg:pt-40">
        <div class="max-w-7xl mx-auto">
            <!-- Heading -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-12 gap-8">
                <h2 class="text-3xl sm:text-4xl font-bold text-center md:text-left max-w-xl">
                    Baca Artikel Kami <br />
                    Tentang Dunia Kolam Renang
                </h2>
                <p class="text-gray-500 text-justify md:text-left font-medium text-base max-w-xl">
                    Disini, Anda akan menemukan berbagai artikel yang mmebahas segala aspek, mulai dari sisi teknis
                    hingga
                    inspirasi desain
                </p>
            </div>

            <!-- Card Artikel -->
            <!-- resources/views/components/artikel-slider.blade.php -->

            <!-- Responsive Article Slider - Fixed Version -->
            <div x-data="artikelSlider(@js($artikels))" x-init="init()" @mouseenter="stopAutoPlay()"
                @mouseleave="startAutoPlay()" class="relative py-8">

                <!-- Slider Container -->
                <div class="overflow-hidden" x-ref="slider">
                    <div class="flex transition-transform duration-500 ease-in-out"
                        :style="`transform: translateX(-${currentSlide * (100 / itemsPerView())}%)`">

                        <!-- Article Cards -->
                        @foreach ($artikels as $artikel)
                            <div class="flex-shrink-0 px-3 mb-2 w-full md:w-1/2 lg:w-1/3">
                                <div
                                    class="bg-white rounded-lg transition-shadow duration-300 overflow-hidden h-full mb-2">
                                    <!-- Article Image -->
                                    <div class="relative overflow-hidden h-48">
                                        <img src="{{ Storage::url($artikel->image) }}" alt="Image-{{ $artikel->title }}"
                                            class="w-full h-full object-cover transition-transform duration-300 hover:scale-105"
                                            loading="lazy" />
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent">
                                        </div>
                                    </div>

                                    <!-- Article Content -->
                                    <div class="p-6">
                                        <!-- Date -->
                                        <p class="text-sm text-gray-500 mb-3 flex items-center">
                                            <i class="fa-solid fa-calendar-days me-2"></i>
                                            {{ $artikel->created_at->format('d M Y') }}
                                        </p>

                                        <!-- Title -->
                                        <h3 class="text-xl font-semibold text-gray-900 mb-3 line-clamp-2 leading-tight">
                                            {{ $artikel->title }}
                                        </h3>

                                        <!-- Excerpt -->
                                        <div class="text-gray-600 mb-4 line-clamp-3 text-sm leading-relaxed">
                                            <span x-text="getExcerpt(@js($artikel->content), 120)"></span>
                                        </div>

                                        <!-- Read More Button -->
                                        <button @click="openModal(@js($artikel))"
                                            class="inline-flex items-center text-blue-700 hover:underline font-medium text-sm duration-200 cursor-pointer">
                                            Baca Selengkapnya
                                            {{-- <i class="fa-solid fa-arrow-right ml-1 text-xs"></i> --}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Navigation Arrows -->
                <div class="flex justify-center gap-2 mt-4" x-show="shouldShowNavigation()">
                    <button @click="prevSlide()"
                        class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50 transition-colors duration-200"
                        :disabled="currentSlide === 0"
                        :class="{
                            'opacity-50 cursor-not-allowed': currentSlide === 0,
                            'hover:border-blue-500': currentSlide >
                                0
                        }">
                        <i class="fa-solid fa-chevron-left text-gray-600"></i>
                    </button>
                    <button @click="nextSlide()"
                        class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50 transition-colors duration-200"
                        :disabled="currentSlide >= maxSlide()"
                        :class="{
                            'opacity-50 cursor-not-allowed': currentSlide >=
                                maxSlide(),
                            'hover:border-blue-500': currentSlide < maxSlide()
                        }">
                        <i class="fa-solid fa-chevron-right text-gray-600"></i>
                    </button>
                </div>

                <!-- Modal -->
                <div x-show="showModal" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">

                    <!-- Backdrop -->
                    <div class="fixed inset-0 bg-black/50 transition-opacity" @click="closeModal()"></div>

                    <!-- Modal Content -->
                    <div class="flex min-h-full items-center justify-center p-4">
                        <div x-show="showModal" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            class="relative bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-hidden"
                            @click.stop>

                            <!-- Close Button -->
                            <button @click="closeModal()"
                                class="absolute top-4 right-4 z-10 w-8 h-8 rounded-full bg-white shadow-md flex items-center justify-center hover:bg-gray-50 transition-colors duration-200">
                                <i class="cursor-pointer fa-solid fa-times text-gray-600"></i>
                            </button>

                            <!-- Modal Body -->
                            <div class="overflow-y-auto max-h-[90vh]" x-show="selectedArtikel">
                                <!-- Hero Image -->
                                <div class="relative h-64 md:h-80 overflow-hidden">
                                    <img :src="selectedArtikel ? '{{ Storage::url('') }}' + selectedArtikel.image : ''"
                                        :alt="selectedArtikel ? 'Image-' + selectedArtikel.title : ''"
                                        class="w-full h-full object-cover" />
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                                </div>

                                <!-- Content -->
                                <div class="p-6 md:p-8">
                                    <!-- Date -->
                                    <p class="text-sm text-gray-500 mb-4 flex items-center">
                                        <i class="fa-solid fa-calendar-days me-2"></i>
                                        <span
                                            x-text="selectedArtikel ? formatDate(selectedArtikel.created_at) : ''"></span>
                                    </p>

                                    <!-- Title -->
                                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6 leading-tight"
                                        x-text="selectedArtikel ? selectedArtikel.title : ''"></h1>

                                    <!-- Content -->
                                    <div class="prose prose-lg max-w-none mb-8">
                                        <div x-html='selectedArtikel ? selectedArtikel.content : ""'
                                            class="text-gray-700 leading-relaxed"></div>
                                    </div>

                                    <!-- Tags -->
                                    <div class="mb-8"
                                        x-show="selectedArtikel && selectedArtikel.tags && selectedArtikel.tags.length > 0">
                                        <h4 class="text-sm font-semibold text-gray-900 mb-3">Tags:</h4>
                                        <div class="flex flex-wrap gap-2">
                                            <template x-for="tag in (selectedArtikel ? selectedArtikel.tags || [] : [])"
                                                :key="tag">
                                                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full"
                                                    x-text="tag"></span>
                                            </template>
                                        </div>
                                    </div>

                                    <!-- Footer -->
                                    <div class="border-t pt-6">
                                        <div
                                            class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                            <div class="text-sm text-gray-500">
                                                Dipublikasikan pada
                                                <span
                                                    x-text="selectedArtikel ? formatDateLong(selectedArtikel.created_at) : ''"
                                                    class="font-medium"></span>
                                            </div>
                                            <div class="flex gap-3">
                                                <button @click="shareArticle()"
                                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 text-sm">
                                                    <i class="fa-solid fa-share me-2"></i>Bagikan
                                                </button>
                                                {{-- <button @click="closeModal()"
                                                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200 text-sm">
                                                    Tutup
                                                </button> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Footer -->
    <footer class="pt-10 sm:pt-14 lg:pt-20">
        <div class="bg-gradient-to-t from-[#172554] via-black to-black text-white px-6 pt-12 pb-6">
            <div class="max-w-8xl mx-auto grid md:grid-cols-3 gap-4">
                <!-- Kiri: Informasi Kontak -->
                <div class="mx-auto max-w-6xl">
                    <!-- Logo -->
                    <div class="flex items-center mb-6">
                        <img src="img/logo.png" alt="Oanes Pools Logo" class="w-8 h-8 mr-2" />
                        <span class="text-xl font-semibold text-blue-400">Oanes Pools</span>
                    </div>
                    <!-- Headline -->
                    <h3 class="text-2xl font-bold mb-4">
                        Hubungi Kami untuk Mewujudkan Kolam Renang Impian Anda!
                    </h3>
                    <!-- Deskripsi -->
                    <p class="text-gray-300 mb-6">
                        Siap memulai proyek kolam renang impian Anda? Jangan ragu untuk
                        menghubungi kami. Tim ahli kami siap membantu Anda dari tahap
                        konsultasi hingga pengerjaan selesai.
                    </p>
                    <!-- Alamat -->
                    <div class="mt-16 flex flex-row items-center">
                        <h3 class="font-base mb-4 flex flex-row items-center gap-2">
                            <i class="iconbase fa-solid fa-location-dot"></i>
                            <a class="hover:underline" href="https://maps.app.goo.gl/kopSfsG9RngBUT6e8" target="_blank"">
                                Jl. M Kahfi Jagakarsa, Jakarta Selatan, Indonesia
                            </a>
                        </h3>
                    </div>
                </div>


                <div class="mx-auto max-w-7xl">
                    <h1 class="text-lg font-semibold mb-6">Hubungi Kami</h1>
                    <!-- WhatsApp -->
                    <div class="flex flex-row items-center mb-2">
                        <h3 class="font-base flex flex-row items-center gap-2">
                            <i class="iconbase fa-brands fa-whatsapp"></i>
                            <a class="hover:underline" href="https://wa.me/6281291100645" target="_blank">
                                0812 9110 0645
                            </a>
                        </h3>
                    </div>
                    <!-- Instagram -->
                    <div class="flex flex-row items-center mb-2 ">
                        <h3 class="font-base flex flex-row items-center gap-2">
                            <i class="iconbase fa-brands fa-instagram"></i>
                            <a class="hover:underline" href="https://www.instagram.com/oanes_pools/" target="_blank">
                                @oanes_pools
                            </a>
                        </h3>
                    </div>
                    <!-- Facebook -->
                    <div class="flex flex-row items-center mb-2">
                        <h3 class="font-base flex flex-row items-center gap-2">
                            <i class="iconbase fa-brands fa-facebook"></i>
                            <a class="hover:underline" href="https://www.facebook.com/oanes.pools" target="_blank">
                                Oanes Pools
                            </a>
                        </h3>
                    </div>
                    <!-- Gmail -->
                    <div class="flex flex-row items-center mb-2">
                        <h3 class="font-base flex flex-row items-center gap-2">
                            <i class="iconbase fa-solid fa-envelope"></i>
                            <a class="hover:underline" href="mailto:oanes@gmail.com" target="_blank">
                                oanespools@gmail.com
                            </a>
                        </h3>
                    </div>
                </div>

                <!-- Tengah: Form Penilaian -->
                <div>
                    @if (session('success'))
                        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h1 class="text-lg font-semibold mb-6">Beri Kami Penilaian</h1>
                    <form id="formTestimoni" action="{{ route('testimoni.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="text" name="nama" placeholder="Nama"
                            class="w-full p-2 rounded bg-white/10 text-white placeholder-white/70" required>
                        <input type="text" name="domisili" placeholder="Domisili"
                            class="w-full p-2 rounded bg-white/10 text-white placeholder-white/70" required>
                        <textarea name="pesan" rows="4" placeholder="Pesan"
                            class="w-full p-2 rounded bg-white/10 text-white placeholder-white/70" required></textarea>
                        <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded cursor-pointer">Kirim</button>
                    </form>
                </div>

            </div>

            <!-- Bawah: Copyright -->
            <div class="flex flex-row justify-center mt-12 pt-6 text-sm text-gray-200">
                <p>Oanes Pools 2025 | Syarat dan Ketentuan Berlaku</p>
            </div>
        </div>
    </footer>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Simple testimonial form handler
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form[action*="testimoni"]');
            if (!form) return;

            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                const btn = this.querySelector('button[type="submit"]');
                const originalText = btn.innerHTML;

                // Loading
                btn.disabled = true;
                btn.innerHTML = 'Mengirim...';

                try {
                    const response = await fetch(this.action, {
                        method: 'POST',
                        body: new FormData(this),
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    const result = await response.json();

                    if (response.ok && result.success) {
                        // Sukses
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: result.message,
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            // Reload halaman untuk update testimoni
                            window.location.reload();
                        });
                    } else {
                        // Error
                        const errorMsg = result.errors ?
                            Object.values(result.errors).flat().join('\n') :
                            result.message || 'Terjadi kesalahan';

                        Swal.fire('Error!', errorMsg, 'error');
                    }
                } catch (error) {
                    Swal.fire('Error!', 'Terjadi kesalahan', 'error');
                } finally {
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }
            });
        });
    </script>
@endpush
