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
    <section class="relative px-6 pb-16">
        <div class="relative bg-cover bg-center rounded-2xl overflow-hidden"
            style="background-image: url('img/header.jpg'); height: 600px">
            <!-- Overlay -->
            <div class="absolute inset-0 bg-black/30 rounded-2xl"></div>

            <!-- Text Content -->
            <div class="absolute inset-0 flex flex-col justify-center px-8 sm:px-12 lg:px-20 text-white">
                <span class="text-lg mb-2">#1 ahli kolam renang</span>
                <h1 class="text-6xl sm:text-7xl font-bold max-w-full">
                    Solusi Lengkap <br />
                    Kolam Renang Anda
                </h1>
                <a href="#"
                    class="font-semibold mt-6 w-max px-5 py-3 border border-white rounded-full text-sm hover:bg-white hover:text-black transition">Hubungi
                    Kami</a>
            </div>
            <div class="absolute right-0 bottom-0 bg-gray-50 shadow-lg rounded-tl-3xl p-14 grid grid-cols-2 gap-16">
                <div class="text-center">
                    <p class="text-5xl font-bold text-blue-700">{{ $hero->jumlah_proyek ?? 0 }}+</p>
                    <p class="text-gray-500">Proyek Selesai</p>
                </div>
                <div class="text-center">
                    <p class="text-5xl font-bold text-blue-700">{{ $hero->jumlah_pelanggan ?? 0 }}+</p>
                    <p class="text-gray-500">Pelanggan</p>
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

    <section class="px-6 py-20 bg-gray-50" x-data="popupCards({{ Js::from($cards) }})">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-12">
                <h2 class="text-3xl sm:text-4xl font-bold max-w-lg">
                    Kami Melayani Beragam <br /> Kebutuhan Anda
                </h2>
                <p class="text-gray-500 text-justify font-medium text-md max-w-xl">
                    Apapun kebutuhan kolam renang Anda, kami punya solusinya. Kami
                    menyediakan layanan terpadu untuk pembangunan, perbaikan, dan
                    perawatan kolam renang.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                <template x-for="(card, index) in cards" :key="index">
                    <div class="relative rounded-2xl overflow-hidden shadow-lg group cursor-pointer"
                        @click="openModal(card)">
                        <img :src="card.image" :alt="card.title"
                            class="w-full h-80 object-cover group-hover:scale-105 transition" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent"></div>
                        <div class="absolute bottom-4 left-4 text-white">
                            <h3 class="text-xl font-semibold" x-text="card.title"></h3>
                            {{-- <p class="text-lg" x-text="card.subtitle"></p> --}}
                        </div>
                    </div>
                </template>
            </div>

            {{-- Modal --}}
            <div x-show="showModal" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4"
                @click.self="closeModal()">
                <div class="bg-white rounded-lg max-w-xl w-full overflow-hidden shadow-lg">
                    <img :src="selectedCard.image" class="w-full h-64 object-cover" />
                    <div class="p-6">
                        <h3 class="text-2xl font-semibold mb-2" x-text="selectedCard.title"></h3>
                        <div class="text-gray-600 mb-4" x-html="selectedCard.description"></div>
                        <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700" @click="closeModal()">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- WHY US (ikon pakai Font Awesome dari npm, lihat langkah 4) --}}
    <section class="px-6 py-20">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-12 gap-6">
                <h2 class="text-3xl sm:text-4xl font-bold max-w-xl">
                    Kenapa Anda Harus <br />
                    Memilih Kami?
                </h2>
                <p class="text-gray-500 text-justify font-medium text-md max-w-xl">
                    Kami hadir untuk memberikan lebih dari sekadar layanan, kami
                    menawarkan solusi lengkap yang didukung oleh pengalaman, kualitas
                    bahan terbaik, dan tim profesional.
                </p>
            </div>

            <!-- Grid Content -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Item 1 -->
                <div class="flex flex-col gap-4 bg-white rounded-2xl p-6">
                    <div class="bg-blue-50 p-2 rounded-lg text-blue-600 text-3xl w-max">
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
                        <p class="text-gray-600 text-md">
                            Didukung oleh tim ahli yang berpengalaman dan bersertifikat,
                            kami menjamin setiap pengerjaan kolam renang dilakukan dengan
                            standar tertinggi.
                        </p>
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="flex flex-col gap-4 bg-white rounded-2xl p-6">
                    <div class="bg-blue-50 p-2 rounded-lg text-blue-600 text-3xl w-max">
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
                        <h3 class="text-lg font-bold mb-3">Cepat dan Akurat</h3>
                        <p class="text-justify text-gray-600 text-md">
                            Dengan manajemen proyek yang efisien, kami memastikan setiap
                            pekerjaan selesai tepat waktu sesuai dengan jadwal yang telah
                            disepakati.
                        </p>
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="flex flex-col gap-4 bg-white rounded-2xl p-6">
                    <div class="bg-blue-50 p-2 rounded-lg text-blue-600 text-3xl w-max">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24">
                            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2">
                                <path stroke-linejoin="round"
                                    d="M2.75 12H6a2 2 0 0 1 2 2a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2a2 2 0 0 1 2-2h3.25" />
                                <path d="M21.25 10.375v4.875a6 6 0 0 1-6 6h-6.5a6 6 0 0 1-6-6v-6.5a6 6 0 0 1 6-6h4.875" />
                                <path stroke-linejoin="round"
                                    d="m16.25 5.582l1.407 1.407a.53.53 0 0 0 .757 0l2.836-2.836" />
                            </g>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold mb-3">Bahan Berkualitas</h3>
                        <p class="text-gray-600 text-md">
                            Kualitas kolam renang dimulai dari bahan baku. Kami hanya
                            menggunakan bahan-bahan terbaik dan teruji yang tahan lama serta
                            aman, sehingga kolam renang indah, kokoh dan awet.
                        </p>
                    </div>
                </div>

                <!-- Item 4 -->
                <div class="flex flex-col gap-4 bg-white rounded-2xl p-6">
                    <div class="bg-blue-50 p-2 rounded-lg text-blue-600 text-3xl w-max">
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
                        <h3 class="text-lg font-bold mb-3">Harga Bersahabat</h3>
                        <p class="text-gray-600 text-md">
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
        // Gambar dan video dengan data yang terpisah
        $imageData = $images->map(
            fn($img) => [
                'src' => asset('storage/' . $img->path),
                'alt' => $img->name,
            ],
        );

        $videoItems = $videos->filter(fn($g) => $g->type === 'video' && $g->is_youtube)->map(function ($g) {
            return (object) [
                'title' => $g->name ?? 'Video',
                'href' => $g->full_url, // URL YouTube original → Fancybox auto-embed
                'thumb' => $g->thumbnail_url ?? asset('img/placeholder-video.jpg'),
            ];
        });
    @endphp

    <section class="px-6 py-20">
        <div class="max-w-7xl mx-auto">

            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between mb-8 gap-6">
                <h2 class="text-3xl sm:text-4xl font-bold max-w-xl">
                    Intip Pekerjaan Hebat Kami <br />
                    Dari Tangan Ahli
                </h2>
                <p class="text-gray-500 text-justify font-medium text-md max-w-xl">
                    Lihatlah sendiri bukti dari keahlian kami. Dalam galeri ini,
                    terdapat berbagai proyek kolam renang yang telah kami selesaikan,
                    mulai dari desain modern hingga renovasi yang mengagumkan.
                </p>
            </div>

            {{-- =================== VIDEO SLIDER =================== --}}
            @if ($videoItems->isNotEmpty())

                {{-- Main Video Slider --}}
                <div class="relative mb-10 rounded-2xl overflow-hidden max-h-[500px] max-w-[1000px] mx-auto">
                    <div class="mySwiper js-video-swiper max-h-[500px] max-w-[1000px]">
                        <div class="swiper-wrapper">
                            @foreach ($videoItems as $it)
                                <div class="swiper-slide max-h-[500px] max-w-[1000px]">
                                    <a data-fancybox="videos" href="{{ $it->href }}"
                                        data-caption="{{ $it->title }}"
                                        class="block relative rounded-2xl object-cove=h-44 cursor-pointer">

                                        <div class="relative pt-[56.25%] bg-black max-h-[600px] max-w-[1000px]">
                                            <img src="{{ $it->thumb }}" alt="{{ $it->title }}"
                                                class="absolute inset-0 h-44  object-cover transition-transform duration-300 group-hover:scale-105"
                                                loading="lazy" />

                                            <!-- Centering the Play Button -->
                                            <div class="absolute inset-0 flex items-center justify-center">
                                                <div class="bg-white/80 rounded-full p-4 backdrop-blur-sm">
                                                    <svg class="w-8 h-8 text-black" viewBox="0 0 20 20"
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
        </div>

        @endif

        <section class="bg-white" x-data="gallerySlider({{ Js::from($imageData) }})" x-init="startSlide()">
            <div class="max-w-8xl mx-auto">
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
                                <!-- Menggunakan image.src dan image.alt yang benar -->
                                <a data-fancybox="images" :href='image.src' :data-sources='image.src'
                                    :data-caption="image.alt" class="cursor-pointer">
                                    <img :src="image.src" :alt="image.alt"
                                        class="rounded-xl object-cover w-full h-44 cursor-pointer" />
                                </a>
                            </template>
                        </div>
                    </template>

                </div>

                <!-- Modal Popup (Handled by Fancybox) -->
            </div>
        </section>


        </div>
    </section>


    <!--Article Section-->
    <section class="px-6 py-20 text-black">
        <div class="max-w-7xl mx-auto">
            <!-- Heading -->
            <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold leading-tight md:max-w-xl">
                    Baca Artikel Kami Tentang Dunia Kolam Renang
                </h2>
                <p class="text-gray-500 text-justify font-medium text-md max-w-xl">
                    Di sini, Anda akan menemukan berbagai artikel yang membahas segala
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
                                    class="bg-white rounded-lg transition-shadow duration-300 overflow-hidden h-full mb-2">
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

                <!-- Indicators -->
                {{-- <div class="flex justify-center gap-2 mt-2" x-show="shouldShowNavigation()">
                    <template x-for="(dot, index) in Array.from({length: maxSlide() + 1})" :key="index">
                        <button @click="goToSlide(index)" class="w-3 h-3 rounded-full transition-colors duration-200"
                            :class="currentSlide === index ? 'bg-blue-600' : 'bg-gray-300 hover:bg-gray-400'">
                        </button>
                    </template>
                </div> --}}

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
                                <i class="fa-solid fa-times text-gray-600"></i>
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

    <!--Testimoni Section-->
    <section class="px-6 py-20">
        <div class="max-w-7xl mx-auto">
            <!-- Heading -->
            <div class="flex flex-col md:flex-row justify-between mb-12 gap-8">
                <div class="md:w-1/2">
                    <h2 class="text-3xl sm:text-4xl font-bold mb-4">
                        Kata Mereka Tentang <br />Pekerjaan Kami
                    </h2>
                </div>
                <p class="text-gray-500 text-justify font-medium text-md max-w-xl">
                    Kepuasan Anda adalah prioritas kami. Baca langsung pengalaman dan
                    testimoni dari para pelanggan yang telah mempercayakan proyek
                    kolam renangnya kepada kami.
                </p>
            </div>

            <!-- Testimonials Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Testimonial 1 -->
                <div class="bg-white rounded-2xl p-10">
                    <p class="text-gray-800 text-lg mb-4">
                        "Saya sangat puas dengan hasilnya! Mulai dari konsultasi sampai
                        kolam renang selesai, timnya sangat profesional dan komunikatif.
                        Kualitas bahannya juga tidak main-main. Kolam renang impian
                        keluarga kami akhirnya terwujud. Terima kasih banyak!"
                    </p>
                    <div>
                        <p class="font-semibold text-lg">Bpk. Jonanda</p>
                        <p class="text-gray-600">Jakarta Selatan</p>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-white rounded-2xl p-10">
                    <p class="text-gray-800 text-lg mb-4">
                        "Pelayanan purna jualnya jempolan! Setelah pembangunan kolam
                        renang selesai, mereka masih rutin membantu perawatan. Timnya
                        sigap dan selalu memberikan solusi terbaik jika ada masalah. Saya
                        merasa tenang karena kolam renang saya selalu terawat dengan
                        baik."
                    </p>
                    <div>
                        <p class="font-semibold text-lg">Bpk. Darey</p>
                        <p class="text-gray-600">Bandung Barat</p>
                    </div>
                </div>
            </div>

            <!-- Arrows -->
            <div class="flex justify-center mt-10 gap-4">
                <button class="w-10 h-10 rounded-full border flex items-center justify-center hover:bg-gray-100 transition"
                    aria-label="Sebelumnya">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button class="w-10 h-10 rounded-full border flex items-center justify-center hover:bg-gray-100 transition"
                    aria-label="Selanjutnya">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
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
                <h3 class="font-base mb-4 flex flex-row items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                        <g fill="none" fill-rule="evenodd">
                            <path
                                d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z" />
                            <path fill="currentColor"
                                d="M12 2a9 9 0 0 1 9 9c0 3.074-1.676 5.59-3.442 7.395a20.4 20.4 0 0 1-2.876 2.416l-.426.29l-.2.133l-.377.24l-.336.205l-.416.242a1.87 1.87 0 0 1-1.854 0l-.416-.242l-.52-.32l-.192-.125l-.41-.273a20.6 20.6 0 0 1-3.093-2.566C4.676 16.589 3 14.074 3 11a9 9 0 0 1 9-9m0 2a7 7 0 0 0-7 7c0 2.322 1.272 4.36 2.871 5.996a18 18 0 0 0 2.222 1.91l.458.326q.222.155.427.288l.39.25l.343.209l.289.169l.455-.269l.367-.23q.293-.186.627-.417l.458-.326a18 18 0 0 0 2.222-1.91C17.728 15.361 19 13.322 19 11a7 7 0 0 0-7-7m0 3a4 4 0 1 1 0 8a4 4 0 0 1 0-8m0 2a2 2 0 1 0 0 4a2 2 0 0 0 0-4" />
                        </g>
                    </svg>
                    Jl. Selamat Datang, Jakarta Selatan
                </h3>
                <h3 class="font-base mb-16 flex flex-row items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                        <path fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="1.5"
                            d="M7.829 16.171a20.9 20.9 0 0 1-4.846-7.614c-.573-1.564-.048-3.282 1.13-4.46l.729-.728a2.11 2.11 0 0 1 2.987 0l1.707 1.707a2.11 2.11 0 0 1 0 2.987l-.42.42a1.81 1.81 0 0 0 0 2.56l3.84 3.841a1.81 1.81 0 0 0 2.56 0l.421-.42a2.11 2.11 0 0 1 2.987 0l1.707 1.707a2.11 2.11 0 0 1 0 2.987l-.728.728c-1.178 1.179-2.896 1.704-4.46 1.131a20.9 20.9 0 0 1-7.614-4.846Z" />
                    </svg>
                    0987654321
                </h3>
            </div>

            <!-- Kanan: Form Penilaian -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Beri Kami Penilaian</h4>
                <form class="space-y-4">
                    <div>
                        <input type="text" placeholder="Nama" required
                            class="w-full p-3 rounded-md bg-transparent border border-gray-400 text-white placeholder-gray-500 font-family" />
                    </div>
                    <div>
                        <input type="text" placeholder="Domisili"
                            class="w-full p-3 rounded-md bg-transparent border border-gray-400 text-white placeholder-gray-500 font-family" />
                    </div>
                    <div>
                        <textarea rows="4" placeholder="Pesan" required
                            class="w-full p-3 rounded-md bg-transparent border border-gray-400 text-white placeholder-gray-500 font-family"></textarea>
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-sm text-white py-2 px-4 rounded-lg">
                        Kirim penilaian
                    </button>
                </form>
            </div>
        </div>

        <!-- Bawah: Copyright -->
        <div class="flex flex-row justify-between mt-12 border-t border-gray-700 pt-6 text-sm text-gray-400">
            <p>Oanes Pools 2025 | Syarat dan Ketentuan Berlaku</p>
            <!-- Icon Sosial -->
            <div class="flex space-x-4">
                <a href="#" class="text-white hover:text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-2c-.55 0-1 .45-1 1v2h3v3h-3v6.95c5.05-.5 9-4.76 9-9.95" />
                    </svg>
                </a>
                <a href="#" class="text-white hover:text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 48 48">
                        <defs>
                            <mask id="SVGy4YSvdBO">
                                <g fill="none">
                                    <path fill="#fff" stroke="#fff" stroke-linejoin="round" stroke-width="4"
                                        d="M34 6H14a8 8 0 0 0-8 8v20a8 8 0 0 0 8 8h20a8 8 0 0 0 8-8V14a8 8 0 0 0-8-8Z" />
                                    <path fill="#000" stroke="#000" stroke-linejoin="round" stroke-width="4"
                                        d="M24 32a8 8 0 1 0 0-16a8 8 0 0 0 0 16Z" />
                                    <path fill="#000" d="M35 15a2 2 0 1 0 0-4a2 2 0 0 0 0 4" />
                                </g>
                            </mask>
                        </defs>
                        <path fill="currentColor" d="M0 0h48v48H0z" mask="url(#SVGy4YSvdBO)" />
                    </svg>
                </a>
                <a href="#" class="text-white hover:text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M12.001 2c5.523 0 10 4.477 10 10s-4.477 10-10 10a9.95 9.95 0 0 1-5.03-1.355L2.005 22l1.352-4.968A9.95 9.95 0 0 1 2.001 12c0-5.523 4.477-10 10-10M8.593 7.3l-.2.008a1 1 0 0 0-.372.1a1.3 1.3 0 0 0-.294.228c-.12.113-.188.211-.261.306A2.73 2.73 0 0 0 6.9 9.62c.002.49.13.967.33 1.413c.409.902 1.082 1.857 1.97 2.742c.214.213.424.427.65.626a9.45 9.45 0 0 0 3.84 2.046l.568.087c.185.01.37-.004.556-.013a2 2 0 0 0 .833-.231a5 5 0 0 0 .383-.22q.001.002.125-.09c.135-.1.218-.171.33-.288q.126-.13.21-.302c.078-.163.156-.474.188-.733c.024-.198.017-.306.014-.373c-.004-.107-.093-.218-.19-.265l-.582-.261s-.87-.379-1.402-.621a.5.5 0 0 0-.176-.041a.48.48 0 0 0-.378.127c-.005-.002-.072.055-.795.931a.35.35 0 0 1-.368.13a1.4 1.4 0 0 1-.191-.066c-.124-.052-.167-.072-.252-.108a6 6 0 0 1-1.575-1.003c-.126-.11-.243-.23-.363-.346a6.3 6.3 0 0 1-1.02-1.268l-.059-.095a1 1 0 0 1-.102-.205c-.038-.147.061-.265.061-.265s.243-.266.356-.41c.11-.14.203-.276.263-.373c.118-.19.155-.385.093-.536q-.42-1.026-.868-2.041c-.059-.134-.234-.23-.393-.249q-.081-.01-.162-.016a3 3 0 0 0-.403.004z" />
                    </svg>
                </a>
            </div>
        </div>
    </footer>

@endsection

@push('scripts')
@endpush
