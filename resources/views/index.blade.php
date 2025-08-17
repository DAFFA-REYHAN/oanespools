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
    <section class="relative px-6 pb-32">
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
            <div class="absolute bottom-10 right-8 flex gap-4 z-12">
                <div class="bg-white p-8 rounded-2xl shadow-lg w-48 text-center">
                    <p class="text-3xl font-bold">14+</p>
                    <p class="text-md text-gray-700 mt-1">Proyek Selesai</p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-lg w-48 text-center">
                    <p class="text-3xl font-bold">50+</p>
                    <p class="text-md text-gray-700 mt-1">Pelanggan</p>
                </div>
            </div>
        </div>
    </section>

    {{-- SERVICES --}}
    @php
        $cards = isset($layanans)
            ? $layanans->map(
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
                <p class="text-gray-700 text-md max-w-2xl">
                    Apapun kebutuhan kolam renang Anda, kami punya solusinya. Kami
                    menyediakan layanan terpadu untuk pembangunan, perbaikan, dan
                    perawatan kolam renang, memastikan Anda mendapatkan hasil yang
                    memuaskan dan bebas dari rasa khawatir.
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
                            <p class="text-lg" x-text="card.subtitle"></p>
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
    <section class="px-6 py-20 bg-white">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-12 gap-6">
                <h2 class="text-3xl sm:text-4xl font-bold max-w-xl">
                    Kenapa Anda Harus <br />
                    Memilih Kami?
                </h2>
                <p class="text-gray-700 text-md max-w-2xl">
                    Kami hadir untuk memberikan lebih dari sekadar layanan, kami
                    menawarkan solusi lengkap yang didukung oleh pengalaman, kualitas
                    bahan terbaik, dan tim profesional. Karena kami berkomitmen untuk
                    mewujudkan kolam renang impian Anda.
                </p>
            </div>

            <!-- Grid Content -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Item 1 -->
                <div class="flex gap-4 bg-white border rounded-2xl p-10 shadow-sm">
                    <div class="text-blue-600 text-3xl">
                        <!-- Icon dummy -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold mb-3">Tim Profesional</h3>
                        <p class="text-gray-600 text-sm">
                            Didukung oleh tim ahli yang berpengalaman dan bersertifikat,
                            kami menjamin setiap pengerjaan kolam renang dilakukan dengan
                            standar tertinggi. Kami tidak hanya bekerja, tetapi juga
                            memberikan solusi terbaik yang sesuai dengan kebutuhan dan visi
                            Anda.
                        </p>
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="flex gap-4 bg-white border rounded-2xl p-10 shadow-sm">
                    <div class="text-blue-600 text-3xl">
                        <!-- Icon dummy -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h4l3 10h7l3-10h4" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold mb-3">Cepat dan Akurat</h3>
                        <p class="text-gray-600 text-sm">
                            Waktu Anda sangat berharga. Dengan manajemen proyek yang efisien
                            dan tim yang solid, kami memastikan setiap pekerjaan
                            diselesaikan tepat waktu sesuai jadwal yang telah disepakati,
                            dengan hasil akhir yang presisi dan memuaskan.
                        </p>
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="flex gap-4 bg-white border rounded-2xl p-10 shadow-sm">
                    <div class="text-blue-600 text-3xl">
                        <!-- Icon dummy -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold mb-3">Bahan Berkualitas</h3>
                        <p class="text-gray-600 text-sm">
                            Kualitas kolam renang dimulai dari bahan baku. Kami hanya
                            menggunakan bahan-bahan terbaik dan teruji yang tahan lama serta
                            aman, sehingga kolam renang Anda tidak hanya indah, tetapi juga
                            kokoh dan awet untuk jangka panjang.
                        </p>
                    </div>
                </div>

                <!-- Item 4 -->
                <div class="flex gap-4 bg-white border rounded-2xl p-10 shadow-sm">
                    <div class="text-blue-600 text-3xl">
                        <!-- Icon dummy -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            class="w-8 h-8">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c1.5 0 3 1 3 2.5S13.5 13 12 13s-3-1-3-2.5S10.5 8 12 8z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 6v12h16V6" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold mb-3">Harga Bersahabat</h3>
                        <p class="text-gray-600 text-sm">
                            Kami memahami bahwa kualitas tidak harus mahal. Dengan harga
                            yang transparan dan kompetitif, kami memastikan Anda mendapatkan
                            layanan terbaik tanpa harus menguras anggaran. Kami berkomitmen
                            untuk memberikan nilai lebih pada setiap investasi yang Anda
                            lakukan.
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
                <p class="text-gray-700 text-md max-w-2xl">
                    Lihatlah sendiri bukti dari keahlian kami. Dalam galeri ini,
                    terdapat berbagai proyek kolam renang yang telah kami selesaikan,
                    mulai dari desain modern hingga renovasi yang mengagumkan.
                </p>
            </div>

            {{-- =================== VIDEO SLIDER =================== --}}
            @if ($videoItems->isNotEmpty())

                {{-- Main Video Slider --}}
                <div class="relative mb-10 rounded-2xl overflow-hidden max-h-[400px]">
                    <div class="mySwiper js-video-swiper max-h-[400px]">
                        <div class="swiper-wrapper">
                            @foreach ($videoItems as $it)
                                <div class="swiper-slide max-h-[400px]">
                                    <a data-fancybox="videos" href="{{ $it->href }}"
                                        data-caption="{{ $it->title }}"
                                        class="block relative rounded-2xl object-cove=h-44 cursor-pointer">

                                        <div class="relative pt-[56.25%] bg-black max-h-[400px]">
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
                        <div class="swiper-button-next  hide-for-small-only hide-for-medium-only" style="color: gray;">
                        </div>
                        <div class="swiper-button-prev  hide-for-small-only hide-for-medium-only" style="color: gray;">
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
    <section class="px-6 py-20 bg-white text-black">
        <div class="max-w-7xl mx-auto">
            <!-- Heading -->
            <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold leading-tight md:max-w-xl">
                    Baca Artikel Kami Tentang Dunia Kolam Renang
                </h2>
                <p class="mt-4 md:mt-0 text-gray-600 md:max-w-md">
                    Di sini, Anda akan menemukan berbagai artikel yang membahas segala
                    aspek, mulai dari sisi teknis hingga inspirasi desain.
                </p>
            </div>

            <!-- Card Artikel -->
            <!-- resources/views/components/artikel-slider.blade.php -->

            <!-- Responsive Article Slider - Fixed Version -->
            <div x-data="artikelSlider(@js($artikels))" x-init="init()" @mouseenter="stopAutoPlay()"
                @mouseleave="startAutoPlay()" class="relative px-4 py-8">

                <!-- Slider Container -->
                <div class="overflow-hidden" x-ref="slider">
                    <div class="flex transition-transform duration-500 ease-in-out"
                        :style="`transform: translateX(-${currentSlide * (100 / itemsPerView())}%)`">

                        <!-- Article Cards -->
                        @foreach ($artikels as $artikel)
                            <div class="flex-shrink-0 px-3 mb-2 w-full md:w-1/2 lg:w-1/3">
                                <div
                                    class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden h-full mb-2">
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
                                            class="inline-flex items-center text-blue-600 hover:text-blue-800 hover:underline font-medium text-sm transition-colors duration-200 cursor-pointer">
                                            Baca Selengkapnya
                                            <i class="fa-solid fa-arrow-right ml-1 text-xs"></i>
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
                        :class="{ 'opacity-50 cursor-not-allowed': currentSlide === 0, 'hover:border-blue-500': currentSlide >
                            0 }">
                        <i class="fa-solid fa-chevron-left text-gray-600"></i>
                    </button>
                    <button @click="nextSlide()"
                        class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50 transition-colors duration-200"
                        :disabled="currentSlide >= maxSlide()"
                        :class="{ 'opacity-50 cursor-not-allowed': currentSlide >=
                        maxSlide(), 'hover:border-blue-500': currentSlide < maxSlide() }">
                        <i class="fa-solid fa-chevron-right text-gray-600"></i>
                    </button>
                </div>

                <!-- Indicators -->
                <div class="flex justify-center gap-2 mt-2" x-show="shouldShowNavigation()">
                    <template x-for="(dot, index) in Array.from({length: maxSlide() + 1})" :key="index">
                        <button @click="goToSlide(index)" class="w-3 h-3 rounded-full transition-colors duration-200"
                            :class="currentSlide === index ? 'bg-blue-600' : 'bg-gray-300 hover:bg-gray-400'">
                        </button>
                    </template>
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
                                                <button @click="closeModal()"
                                                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200 text-sm">
                                                    Tutup
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

    <!--Testimoni Section-->
    <section class="bg-white px-6 py-20">
        <div class="max-w-7xl mx-auto">
            <!-- Heading -->
            <div class="flex flex-col md:flex-row justify-between mb-12 gap-8">
                <div class="md:w-1/2">
                    <h2 class="text-3xl sm:text-4xl font-bold mb-4">
                        Kata Mereka Tentang <br />Pekerjaan Kami
                    </h2>
                </div>
                <div class="md:w-1/2 text-gray-700 text-md">
                    <p>
                        Kepuasan Anda adalah prioritas kami. Baca langsung pengalaman dan
                        testimoni dari para pelanggan yang telah mempercayakan proyek
                        kolam renangnya kepada kami. Kisah mereka adalah bukti nyata dari
                        kualitas dan komitmen kami.
                    </p>
                </div>
            </div>

            <!-- Testimonials Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Testimonial 1 -->
                <div class="border rounded-2xl p-10 shadow-sm">
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
                <div class="border rounded-2xl p-10 shadow-sm">
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

    <!--Footer-->
    <footer class="bg-black text-white px-6 py-16">
        <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-12">
            <!-- Kiri: Informasi Kontak -->
            <div>
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
                <!-- Icon Sosial -->
                <div class="flex space-x-4">
                    <a href="#" class="text-white hover:text-blue-500">
                        <i class="fab fa-facebook fa-lg"></i>
                    </a>
                    <a href="#" class="text-white hover:text-pink-500">
                        <i class="fab fa-instagram fa-lg"></i>
                    </a>
                    <a href="#" class="text-white hover:text-green-500">
                        <i class="fab fa-whatsapp fa-lg"></i>
                    </a>
                </div>
            </div>

            <!-- Kanan: Form Penilaian -->
            <div>
                <h4 class="text-lg font-semibold mb-4">Beri Kami Penilaian</h4>
                <form class="space-y-4">
                    <div>
                        <input type="text" placeholder="Nama" required
                            class="w-full p-3 rounded-md bg-transparent border border-gray-400 text-white placeholder-gray-400" />
                    </div>
                    <div>
                        <input type="text" placeholder="Domisili"
                            class="w-full p-3 rounded-md bg-transparent border border-gray-400 text-white placeholder-gray-400" />
                    </div>
                    <div>
                        <textarea rows="4" placeholder="Pesan" required
                            class="w-full p-3 rounded-md bg-transparent border border-gray-400 text-white placeholder-gray-400"></textarea>
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded-full">
                        Kirim
                    </button>
                </form>
            </div>
        </div>

        <!-- Bawah: Copyright -->
        <div class="mt-12 border-t border-gray-700 pt-6 text-center text-sm text-gray-400">
            Oanes Pools 2025 | Syarat dan Ketentuan Berlaku
        </div>
    </footer>

@endsection

@push('scripts')
@endpush
