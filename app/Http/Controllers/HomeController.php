<?php
// app/Http/Controllers/LandingController.php
namespace App\Http\Controllers;

use App\Models\Hero;
use App\Models\Layanan;
use App\Models\Artikel;
use App\Models\Gallery; // <- pastikan model ini ada
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
      public function index()
    {
        // Ringkasan hero & layanan
        $hero = Hero::select('jumlah_proyek', 'jumlah_pelanggan')->first();
        $layanans = Layanan::select('nama_layanan', 'gambar', 'deskripsi')->get();

        // Ambil gallery berdasarkan type (sesuai struktur database Anda)
        $videos = Gallery::where('type', 'video')->orderBy('created_at', 'desc')->get();
        $images = Gallery::where('type', 'gambar')->orderBy('created_at', 'desc')->get();

        // Artikel
        $artikels = Artikel::select('title', 'content', 'image', 'created_at')->latest()->limit(3)->get();

        // Debug - hapus setelah berhasil
        \Log::info('Videos count: ' . $videos->count());
        \Log::info('Images count: ' . $images->count());

        if ($videos->count() > 0) {
            \Log::info('First video: ' . $videos->first()->name . ' - ' . $videos->first()->path);
        }

        return view('index', compact('hero', 'layanans', 'artikels', 'videos', 'images'));
    }
}
