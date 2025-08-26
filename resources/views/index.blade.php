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
    <section class="relative px-4 sm:px-6 pb-16">
        <div class="relative bg-cover bg-center rounded-2xl overflow-hidden min-h-[450px] sm:min-h-[550px] lg:h-[630px]"
            style="background-image: url('img/header.jpg');">

            <!-- Overlay -->
            <div class="absolute inset-0 bg-black/30 rounded-2xl"></div>

            <!-- Text Content -->
            <div class="absolute inset-0 flex flex-col justify-center px-6 sm:px-12 lg:px-20 text-white">
                <span class="text-sm sm:text-base lg:text-lg mb-2">#1 ahli kolam renang</span>
                <h1 class="text-3xl sm:text-5xl lg:text-7xl font-bold leading-tight max-w-full">
                    Solusi Lengkap <br />
                    Kolam Renang Anda
                </h1>
                <a href="https://wa.me/6281291100645" target="_blank"
                    class="font-semibold mt-6 w-max px-4 sm:px-5 py-2 sm:py-3 text-center border border-white rounded-full text-xs sm:text-sm md:text-base hover:bg-white hover:text-black transition">
                    Hubungi Kami
                </a>
            </div>

            <!-- Statistik -->
            <div
                class="absolute right-0 bottom-0 bg-gray-50 shadow-lg rounded-tl-2xl sm:rounded-tl-3xl p-4 sm:p-8 md:p-14 grid grid-cols-2 gap-6 sm:gap-16 w-full sm:w-auto">
                <div class="text-center">
                    <p class="text-2xl sm:text-4xl md:text-5xl font-bold text-blue-700">{{ $hero->jumlah_proyek ?? 0 }}+</p>
                    <p class="text-gray-500 text-xs sm:text-sm md:text-base">Proyek Selesai</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl sm:text-4xl md:text-5xl font-bold text-blue-700">{{ $hero->jumlah_pelanggan ?? 0 }}+
                    </p>
                    <p class="text-gray-500 text-xs sm:text-sm md:text-base">Pelanggan</p>
                </div>
            </div>
        </div>
    </section>

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

    <section class="px-4 sm:px-6 py-10 bg-gray-50" x-data="popupCards({{ Js::from($cards) }})">
        <div class="max-w-7xl mx-auto">
            <!-- Heading + Deskripsi -->
            <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-12 text-center md:text-left">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold max-w-lg">
                    Kami Melayani Beragam <br /> Kebutuhan Anda
                </h2>
                <p class="text-gray-500 font-medium text-sm sm:text-base md:text-md max-w-xl leading-relaxed">
                    Apapun kebutuhan kolam renang Anda, kami punya solusinya. Kami
                    menyediakan layanan terpadu untuk pembangunan, perbaikan, dan
                    perawatan kolam renang.
                </p>
            </div>

            <!-- Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="(card, index) in cards" :key="index">
                    <div class="relative rounded-2xl overflow-hidden shadow-lg group cursor-pointer"
                        @click="openModal(card)">
                        <img :src="card.image" :alt="card.title"
                            class="w-full h-60 sm:h-72 md:h-80 object-cover group-hover:scale-105 transition duration-300" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent"></div>
                        <div class="absolute bottom-4 left-4 text-white">
                            <h3 class="text-lg sm:text-xl font-semibold" x-text="card.title"></h3>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Modal -->
            <div x-show="showModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4"
                @click.self="closeModal()">
                <div class="bg-white rounded-lg max-w-lg w-full overflow-hidden shadow-lg">
                    <img :src="selectedCard.image" class="w-full h-40 sm:h-56 md:h-64 object-cover" />
                    <div class="p-4 sm:p-6">
                        <h3 class="text-xl sm:text-2xl font-semibold mb-2" x-text="selectedCard.title"></h3>
                        <div class="text-gray-600 mb-4 text-sm sm:text-base leading-relaxed"
                            x-html="selectedCard.description"></div>
                        <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm sm:text-base"
                            @click="closeModal()">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- WHY CHOOSE US --}}
    <section class="px-4 sm:px-6 py-10">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-12 gap-6 text-center md:text-left">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold max-w-xl">
                    Kenapa Anda Harus <br />
                    Memilih Kami?
                </h2>
                <p class="text-gray-500 font-medium text-sm sm:text-base md:text-md max-w-xl leading-relaxed">
                    Kami hadir untuk memberikan lebih dari sekadar layanan, kami
                    menawarkan solusi lengkap yang didukung oleh pengalaman, kualitas
                    bahan terbaik, dan tim profesional.
                </p>
            </div>

            <!-- Grid Content -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Item 1 -->
                <div class="flex flex-col gap-4 bg-white rounded-2xl p-4 sm:p-6 border border-[#f4f4f4]">
                    <div class="bg-blue-50 p-2 rounded-lg text-blue-600 w-max">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 sm:w-7 sm:h-7" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <path d="M1 20v-1a7 7 0 0 1 7-7v0a7 7 0 0 1 7 7v1" />
                            <path d="M13 14v0a5 5 0 0 1 5-5v0a5 5 0 0 1 5 5v.5" />
                            <path stroke-linejoin="round"
                                d="M8 12a4 4 0 1 0 0-8a4 4 0 0 0 0 8m10-3a3 3 0 1 0 0-6a3 3 0 0 0 0 6" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-bold mb-2">Tim Profesional</h3>
                        <p class="text-gray-600 text-sm sm:text-md leading-relaxed">
                            Didukung oleh tim ahli yang berpengalaman dan bersertifikat,
                            kami menjamin setiap pengerjaan kolam renang dilakukan dengan
                            standar tertinggi.
                        </p>
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="flex flex-col gap-4 bg-white rounded-2xl p-4 sm:p-6 border border-[#f4f4f4]">
                    <div class="bg-blue-50 p-2 rounded-lg text-blue-600 w-max">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 sm:w-7 sm:h-7" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M2 22h11a9 9 0 1 0 0-18c-4.633 0-8.503 3.5-9 8m14.5-6.5l1-1m-14 0l1 1" />
                            <path
                                d="m16.5 9l-2.94 2.94m0 0a1.5 1.5 0 1 0-2.121 2.121a1.5 1.5 0 0 0 2.122-2.122M12.5 3.5V2m-2 0h4M2 15h3m-3 4h5" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-bold mb-2">Cepat dan Akurat</h3>
                        <p class="text-gray-600 text-sm sm:text-md leading-relaxed">
                            Dengan manajemen proyek yang efisien, kami memastikan setiap
                            pekerjaan selesai tepat waktu sesuai dengan jadwal yang telah
                            disepakati.
                        </p>
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="flex flex-col gap-4 bg-white rounded-2xl p-4 sm:p-6 border border-[#f4f4f4]">
                    <div class="bg-blue-50 p-2 rounded-lg text-blue-600 w-max">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 sm:w-7 sm:h-7" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <path stroke-linejoin="round"
                                d="M2.75 12H6a2 2 0 0 1 2 2a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2a2 2 0 0 1 2-2h3.25" />
                            <path d="M21.25 10.375v4.875a6 6 0 0 1-6 6h-6.5a6 6 0 0 1-6-6v-6.5a6 6 0 0 1 6-6h4.875" />
                            <path stroke-linejoin="round" d="m16.25 5.582l1.407 1.407a.53.53 0 0 0 .757 0l2.836-2.836" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-bold mb-2">Bahan Berkualitas</h3>
                        <p class="text-gray-600 text-sm sm:text-md leading-relaxed">
                            Kualitas kolam renang dimulai dari bahan baku. Kami hanya
                            menggunakan bahan-bahan terbaik dan teruji yang tahan lama serta
                            aman, sehingga kolam renang indah, kokoh dan awet.
                        </p>
                    </div>
                </div>

                <!-- Item 4 -->
                <div class="flex flex-col gap-4 bg-white rounded-2xl p-4 sm:p-6 border border-[#f4f4f4]">
                    <div class="bg-blue-50 p-2 rounded-lg text-blue-600 w-max">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 sm:w-7 sm:h-7" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M19.745 13a7 7 0 1 0-12.072-1" />
                            <path
                                d="M14 6c-1.105 0-2 .672-2 1.5S12.895 9 14 9s2 .672 2 1.5s-.895 1.5-2 1.5m0-6c.87 0 1.612.417 1.886 1M14 6V5m0 7c-.87 0-1.612-.417-1.886-1M14 12v1M3 14h2.395c.294 0 .584.066.847.194l2.042.988c.263.127.553.193.848.193h1.042c1.008 0 1.826.791 1.826 1.767c0 .04-.027.074-.066.085l-2.541.703a1.95 1.95 0 0 1-1.368-.124L5.842 16.75M12 16.5l4.593-1.411a1.985 1.985 0 0 1 2.204.753c.369.51.219 1.242-.319 1.552l-7.515 4.337a2 2 0 0 1-1.568.187L3 20.02" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-bold mb-2">Harga Bersahabat</h3>
                        <p class="text-gray-600 text-sm sm:text-md leading-relaxed">
                            Kami memahami bahwa kualitas tidak harus mahal. Dengan harga
                            yang transparan dan kompetitif, kami memastikan Anda mendapatkan
                            layanan terbaik tanpa harus menguras anggaran.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
        $videoItems = $videos;
    @endphp

    <section class="px-4 sm:px-6 py-10">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-12 gap-6 text-center md:text-left">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold max-w-xl">
                    Intip Pekerjaan Hebat Kami <br />
                    Dari Tangan Ahli
                </h2>
                <p class="text-gray-500 font-medium text-sm sm:text-base md:text-md max-w-xl leading-relaxed">
                    Lihatlah sendiri bukti dari keahlian kami. Dalam galeri ini,
                    terdapat berbagai proyek kolam renang yang telah kami selesaikan,
                    mulai dari desain modern hingga renovasi yang mengagumkan.
                </p>
            </div>

            {{-- =================== VIDEO SLIDER =================== --}}
            @if ($videoItems->isNotEmpty())
                <div class="relative mb-10 rounded-2xl overflow-hidden max-h-[500px] max-w-[1000px] mx-auto">
                    <div class="mySwiper  max-h-[500px] max-w-[1000px]">
                        <div class="swiper-wrapper">
                            @foreach ($videoItems as $it)
                                <div class="swiper-slide  max-h-[200] sm:max-h-[200] lg:max-h-[500px] max-w-[1000px]">
                                    <!-- Link ke Fancybox untuk membuka video di modal -->
                                    <a data-fancybox="videos" href="#video-{{ $it->id }}"
                                        data-caption="<h6 class='text-center'>{{ $it->name ?? 'Video' }}</h6>  <p class='text-center'>{{ $it->created_at->format('d M Y H:i') }}</p>"
                                        class="block relative rounded-2xl cursor-pointer group">
                                        <div
                                            class="relative pt-[56.25%] max-h-[500px] max-w-[1000px] rounded-2xl overflow-hidden bg-black">
                                            <!-- Video placeholder (thumbnail bisa diganti dengan poster hitam jika tidak ada thumbnail) -->
                                            <video class="absolute inset-0 w-full h-full object-cover" preload="metadata">
                                                <source src="{{ Storage::url($it->path) }}" type="video/mp4">
                                                <source src="{{ Storage::url($it->path) }}" type="video/webm">
                                                <source src="{{ Storage::url($it->path) }}" type="video/ogg">
                                                Your browser does not support the video tag.
                                            </video>

                                            <!-- Play Button Overlay -->
                                            <div class="absolute inset-0 flex items-center justify-center group">
                                                <button
                                                    class="bg-white/80 rounded-full p-4 backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                    <svg class="w-8 h-8 text-black" viewBox="0 0 20 20"
                                                        fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M6.5 5.5a1 1 0 011.538-.843l6 4a1 1 0 010 1.686l-6 4A1 1 0 016.5 13.5v-8z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </a>

                                    <!-- Hidden video element for Fancybox -->
                                    <div id="video-{{ $it->id }}" style="display: none; max-width: 900px;">
                                        <video width="100%" height="auto" controls autoplay
                                            style="max-height:70vh; border-radius:8px;">
                                            <source src="{{ Storage::url($it->path) }}" type="video/mp4">
                                            <source src="{{ Storage::url($it->path) }}" type="video/webm">
                                            <source src="{{ Storage::url($it->path) }}" type="video/ogg">
                                            Your browser does not support the video tag.
                                        </video>

                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Swiper Pagination & Navigation -->
                        @if ($videoItems->count() > 1)
                            <div
                                class="swiper-button-next !text-white !bg-black/50 !rounded-full !w-10 !h-10 after:!text-sm">
                            </div>
                            <div
                                class="swiper-button-prev !text-white !bg-black/50 !rounded-full !w-10 !h-10 after:!text-sm">
                            </div>
                            <div class="swiper-pagination !bottom-4"></div>
                        @endif
                    </div>
                </div>

                <!-- Swiper Init -->
                <script>
                    document.addEventListener('DOMContentLoaded', function() {


                        // Fancybox Init for videos
                        Fancybox.bind("[data-fancybox='videos']", {
                            infinite: true,
                            hideScrollbar: true,
                        });
                    });
                </script>
            @else
                <p class="text-center text-gray-500 mb-10">📹 Data video belum ada</p>
            @endif



            {{-- =================== IMAGE SLIDER =================== --}}
            @if ($imageData->isNotEmpty())
                <section class="px-6" x-data="gallerySlider({{ Js::from($imageData) }})" x-init="startSlide()">
                    <div class="max-w-7xl mx-auto">
                        <!-- Slide Container -->
                        <div class="relative overflow-hidden h-44">
                            <template x-for="(group, groupIndex) in imageGroups" :key="groupIndex">
                                <div class="absolute top-0 left-0 w-full grid grid-cols-2 md:grid-cols-4 gap-4 transition-transform duration-700 ease-in-out"
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
                                                class="rounded-xl object-cover w-full h-44 cursor-pointer" />
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

    <!-- {{-- ARTICLE --}} -->
    <section class="px-4 sm:px-6 py-10">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-12 gap-6 text-center md:text-left">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold max-w-xl">
                    Baca Artikel Kami Tentang Dunia Kolam Renang
                </h2>
                <p class="text-gray-500 font-medium text-sm sm:text-base md:text-md max-w-xl leading-relaxed">
                    LDi sini, Anda akan menemukan berbagai artikel yang membahas segala
                    aspek, mulai dari sisi teknis hingga inspirasi desain.
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
                                    class="bg-white rounded-2xl border border-[#f4f4f4] transition-shadow duration-300 overflow-hidden h-full mb-2">
                                    <!-- Article Image -->
                                    <div class="relative overflow-hidden h-48">
                                        <img src="{{ Storage::url($artikel->image) }}" alt="Image-{{ $artikel->title }}"
                                            class="w-full h-full object-cover transition-transform duration-300 hover:scale-105"
                                            loading="lazy" />
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
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

    {{-- TESTIMONI --}}
    <section class="px-4 sm:px-6 py-10" x-data="{
        current: 0,
        perView: () => window.innerWidth >= 1024 ? 4 : (window.innerWidth >= 640 ? 2 : 1),
        get total() {
            return Math.ceil({{ count($testimonis) }} / this.perView());
        }
    }" x-init="window.addEventListener('resize', () => { current = 0 })">

        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-12 gap-6 text-center md:text-left">
                <div class="text-2xl sm:text-3xl md:text-4xl font-bold max-w-xl">
                    <h2 class="text-3xl sm:text-4xl font-bold mb-4">
                        Kata Mereka Tentang <br />Pekerjaan Kami
                    </h2>
                </div>
                <p class="text-gray-500 font-medium text-sm sm:text-base md:text-md max-w-xl leading-relaxed">
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
                            <div class="w-full sm:w-1/2 lg:w-1/4 flex-shrink-0 py-2 px-3">
                                <div
                                    class="bg-white rounded-2xl p-10 h-full border border-[#f4f4f4] transition flex flex-col justify-between">
                                    <!-- Pesan -->
                                    <p class="text-gray-800 text-lg mb-4 line-clamp-4">
                                        {{ $testi->pesan }}
                                    </p>

                                    <!-- Nama & Domisili -->
                                    <div class="mt-auto">
                                        <p class="font-semibold text-lg">{{ $testi->nama }}</p>
                                        <p class="text-gray-600">{{ $testi->domisili }}</p>
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
            <div class="flex justify-center gap-2 mt-4" x-show="total > 1">
                <!-- Tombol Prev -->
                <button @click="current = current > 0 ? current - 1 : 0"
                    class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50 transition-colors duration-200"
                    :disabled="current === 0"
                    :class="{
                        'opacity-50 cursor-not-allowed': current === 0,
                        'hover:border-blue-500': current > 0
                    }">
                    <i class="fa-solid fa-chevron-left text-gray-600"></i>
                </button>

                <!-- Tombol Next -->
                <button @click="current = current + 1 < total ? current + 1 : current"
                    class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50 transition-colors duration-200"
                    :disabled="current >= total - 1"
                    :class="{
                        'opacity-50 cursor-not-allowed': current >= total - 1,
                        'hover:border-blue-500': current < total - 1
                    }">
                    <i class="fa-solid fa-chevron-right text-gray-600"></i>
                </button>
            </div>

        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-black text-white px-6 pt-12 pb-6">
        <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-48">
            <!-- Kiri: Informasi Kontak -->
            <div class="mx-auto max-w-6xl">
                <!-- Logo -->
                <div class="flex items-center mb-6">
                    <img src="img/logo.png" alt="Oanes Pools Logo" class="w-8 h-8 mr-2" />
                    <span class="text-xl font-bold text-blue-600 italic">Oanes Pools</span>
                </div>
                <!-- Headline -->
                <h3 class="text-xl font-bold text-gray-300 mb-4">
                    Hubungi Kami untuk Mewujudkan Kolam Renang Impian Anda!
                </h3>
                <!-- Deskripsi -->
                <p class="text-gray-600 text-base mb-6 justify">
                    Siap memulai proyek kolam renang impian Anda? Jangan ragu untuk
                    menghubungi kami. Tim ahli kami siap membantu Anda.
                </p>
                <!-- Address -->
                <div class="mt-12">
                    <a href="https://maps.app.goo.gl/kopSfsG9RngBUT6e8" target="_blank"
                        class="flex flex-row items-center ">
                        <h3 class="font-base mb-4 flex flex-row items-center gap-2">
                            <i class="iconbase fa-solid fa-location-dot"></i>
                            Jl. M Kahfi Jagakarsa, Jakarta Selatan, Indonesia
                        </h3>
                    </a>
                    <!-- Gmail -->
                    <a href="mailto:oanes@gmail.com" target="_blank" class="flex flex-row items-center mb-2">
                        <h3 class="font-base flex flex-row items-center gap-2">
                            <i class="iconbase fa-solid fa-envelope"></i>
                            oanespools@gmail.com
                        </h3>
                    </a>
                </div>
            </div>

            <div>


                <form id="formTestimoni" action="{{ route('testimoni.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="text" name="nama" placeholder="Nama"
                        class="w-full border border-gray-500/50 p-2 rounded" required>
                    <input type="text" name="domisili" placeholder="Domisili"
                        class="w-full border border-gray-500/50 p-2 rounded" required>
                    <textarea name="pesan" rows="4" placeholder="Pesan" class="w-full border border-gray-500/50 p-2 rounded"
                        required></textarea>
                    <button type="submit"
                        class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded cursor-pointer">Kirim
                        penilaian</button>
                </form>
            </div>
        </div>

        <!-- Bawah: Copyright -->
        <div
            class="max-w-7xl mx-auto flex flex-row justify-between mt-12 border-t border-gray-200 pt-6 text-sm text-gray-500">
            <!-- Icon Sosial -->
            <div class="flex space-x-4">
                <div class="flex flex-row items-center mb-2">
                    <h3 class="font-base flex flex-row items-center gap-1">
                        <svg class="w-5 h-5">
                            <use xlink:href="#icon-wa"></use>
                        </svg>
                        <a href="https://wa.me/6281291100645" class="hover:underline" target="_blank">
                            0812 9110 0645
                        </a>
                    </h3>
                </div>

                <!-- Facebook -->
                <div class="flex flex-row items-center mb-2">
                    <h3 class="font-base flex flex-row items-center gap-1">
                        <svg class="w-5 h-5">
                            <use xlink:href="#icon-fb"></use>
                        </svg>
                        <a href="https://www.facebook.com/oanes.pools" class="hover:underline" target="_blank">
                            Oanes Pools
                        </a>
                    </h3>
                </div>

                <!-- Instagram -->
                <div class="flex flex-row items-center mb-2">
                    <h3 class="font-base flex flex-row items-center gap-1">
                        <svg class="w-5 h-5">
                            <use xlink:href="#icon-ig"></use>
                        </svg>
                        <a href="https://www.instagram.com/oanes_pools/" class="hover:underline" target="_blank">
                            @oanes_pools
                        </a>
                    </h3>
                </div>
            </div>
            <!-- Terms and Condition -->
            <p>Oanes Pools 2025 | Syarat dan Ketentuan Berlaku</p>
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
