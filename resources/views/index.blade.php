@extends('app')


@section('content')
    <!-- Hero Section -->
    <section class="relative px-6 pb-32">
        <div class="relative bg-cover bg-center rounded-2xl overflow-hidden"
            style="background-image: url('img/header.jpg'); height: 600px">
            <!-- Overlay -->
            <div class="absolute inset-0 bg-black bg-opacity-30 rounded-2xl"></div>

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
                    <p class="text-3xl font-bold">{{ $hero->jumlah_proyek }}+</p>
                    <p class="text-md text-gray-700 mt-1">Proyek Selesai</p>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-lg w-48 text-center">
                    <p class="text-3xl font-bold">{{ $hero->jumlah_pelanggan }}+</p>
                    <p class="text-md text-gray-700 mt-1">Pelanggan</p>
                </div>
            </div>
        </div>
    </section>

    <!--Services Section-->
    <section class="px-6 py-20 bg-gray-50" x-data="popupCards()">
        <div class="max-w-7xl mx-auto">
            <!-- Heading -->
            <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-12">
                <h2 class="text-3xl sm:text-4xl font-bold max-w-lg">
                    Kami Melayani Beragam <br />
                    Kebutuhan Anda
                </h2>
                <p class="text-gray-700 text-md max-w-2xl">
                    Apapun kebutuhan kolam renang Anda, kami punya solusinya. Kami
                    menyediakan layanan terpadu untuk pembangunan, perbaikan, dan
                    perawatan kolam renang, memastikan Anda mendapatkan hasil yang
                    memuaskan dan bebas dari rasa khawatir.
                </p>
            </div>

            <!-- Card Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Debugging: Log cards array to console -->
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

            <!-- Modal -->
            <div x-show="showModal" x-transition
                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-80 p-4"
                @click.self="closeModal()">
                <div class="bg-white rounded-lg max-w-xl w-full overflow-hidden shadow-lg">
                    <img :src="selectedCard.image" class="w-full h-64 object-cover" />
                    <div class="p-6">
                        <h3 class="text-2xl font-semibold mb-2" x-text="selectedCard.title"></h3>
                        <!-- Use x-html to render HTML content -->
                        <div class="text-gray-600 mb-4" x-html="selectedCard.description"></div>
                        <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700" @click="closeModal()">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--Why Choose Us Section-->
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
                        <i class="iconbase fa-solid fa-people-group"></i>
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
                        <i class="iconbase fa-solid fa-clock"></i>
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
                        <i class="iconbase fa-solid fa-box"></i>
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
                        <i class="iconbase fa-solid fa-money-bill"></i>
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

    <!--Gallery Section-->
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

            <!-- Video Thumbnail -->
            <div class="relative mb-10 rounded-2xl overflow-hidden shadow-lg">
                <img src="img/video.jpg" alt="Video Proyek Kolam" class="w-full h-[400px] object-cover" />
                <a href="#" class="absolute inset-0 flex items-center justify-center">
                    <div class="bg-white/80 rounded-full p-4 hover:bg-white transition">
                        <!-- Play Icon -->
                        <svg class="w-10 h-10 text-black" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6.5 5.5a1 1 0 011.538-.843l6 4a1 1 0 010 1.686l-6 4A1 1 0 016.5 13.5v-8z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </a>
            </div>

            <!-- Gallery Grid -->
            <section class="bg-white" x-data="gallerySlider()" x-init="startSlide()">
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
                                    <img :src="image.src" :alt="image.alt"
                                        class="rounded-xl object-cover w-full h-44 cursor-pointer"
                                        @click="openImage(image.src)" />
                                </template>
                            </div>
                        </template>
                    </div>

                    <!-- Modal Popup -->
                    <div x-show="showModal" x-transition
                        class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50"
                        @click.self="closeImage()">
                        <div class="relative">
                            <button class="absolute top-0 right-0 text-white text-3xl px-4 py-2" @click="closeImage()">
                                &times;
                            </button>
                            <img :src="selectedImage" class="max-h-[80vh] max-w-[90vw] rounded-lg shadow-lg" />
                        </div>
                    </div>
                </div>
            </section>
            <!-- <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                      <img
                        src="img/pembangunan.jpg"
                        alt="Before After 1"
                        class="rounded-xl object-cover w-full h-44" />
                      <img
                        src="img/header.jpg"
                        alt="Before After 2"
                        class="rounded-xl object-cover w-full h-44" />
                      <img
                        src="img/renovasi.jpg"
                        alt="Before After 3"
                        class="rounded-xl object-cover w-full h-44" />
                      <img
                        src="img/perawatan.jpg"
                        alt="Before After 4"
                        class="rounded-xl object-cover w-full h-44" />
                    </div> -->
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
            <div class="grid gap-8 md:grid-cols-3">
                <!-- Artikel 1 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition">
                    <img src="img/pembangunan.jpg" alt="Kolam Renang Jernih"
                        class="rounded-xl mb-4 w-full h-48 object-cover" />
                    <p class="text-gray-600 mb-2 text-sm">2 Agustus 2025</p>
                    <h3 class="font-semibold text-lg mb-2">
                        Langkah Mudah Menjaga Air Kolam Tetap Jernih Sepanjang Tahun
                    </h3>
                    <p class="text-gray-600 mb-4 text-sm">
                        Air kolam yang keruh atau berwarna hijau adalah masalah umum yang
                        sering dihadapi pemilik kolam renang, jadi lakukan beberapa
                        langkah berikut.
                    </p>
                    <a href="#" class="text-blue-600 font-medium text-sm hover:underline">
                        Baca Selengkapnya
                    </a>
                </div>

                <!-- Artikel 2 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition">
                    <img src="img/pembangunan.jpg" alt="Kolam Renang Alga"
                        class="rounded-xl mb-4 w-full h-48 object-cover" />
                    <p class="text-gray-600 mb-2 text-sm">2 Agustus 2025</p>
                    <h3 class="font-semibold text-lg mb-2">
                        Cara Praktis Mengatasi Alga dan Air Kolam Hijau dalam Semalam
                    </h3>
                    <p class="text-gray-600 mb-4 text-sm">
                        Melihat air kolam renang yang tadinya jernih tiba-tiba berubah
                        menjadi hijau karena alga tentu sangat menjengkelkan.
                    </p>
                    <a href="#" class="text-blue-600 font-medium text-sm hover:underline">
                        Baca Selengkapnya
                    </a>
                </div>

                <!-- Artikel 3 -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition">
                    <img src="img/pembangunan.jpg" alt="Kolam Renang Flamingo"
                        class="rounded-xl mb-4 w-full h-48 object-cover" />
                    <p class="text-gray-600 mb-2 text-sm">2 Agustus 2025</p>
                    <h3 class="font-semibold text-lg mb-2">
                        Menjaga Kolam Renang Tetap Bersinar dengan Alat Sederhana
                    </h3>
                    <p class="text-gray-600 mb-4 text-sm">
                        Pembersihan kolam renang tidak harus selalu mahal atau rumit.
                        Artikel ini menyediakan panduan langkah demi langkah.
                    </p>
                    <a href="#" class="text-blue-600 font-medium text-sm hover:underline">
                        Baca Selengkapnya
                    </a>
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
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <!-- Testimonial 1 -->
                <div class="border rounded-2xl p-6 shadow-sm">
                    <p class="text-gray-800 text-sm mb-4">
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
                <div class="border rounded-2xl p-6 shadow-sm">
                    <p class="text-gray-800 text-sm mb-4">
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
                <div class="border rounded-2xl p-6 shadow-sm">
                    <p class="text-gray-800 text-sm mb-4">
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
                <div class="border rounded-2xl p-6 shadow-sm">
                    <p class="text-gray-800 text-sm mb-4">
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
