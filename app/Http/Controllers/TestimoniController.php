<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimoni;

class TestimoniController extends Controller
{
    // Halaman utama (landing page)
    public function index()
    {
        // Ambil max 6 testimoni terbaru untuk ditampilkan di landing page
        $testimonis = Testimoni::latest()->take(6)->get();

        return view('index', compact('testimonis'));
    }

    // Simpan testimoni dari form
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'domisili' => 'nullable|string|max:100',
            'pesan' => 'required|string',
        ]);

        Testimoni::create([
            'nama' => $request->nama,
            'domisili' => $request->domisili,
            'pesan' => $request->pesan,
        ]);

        // Redirect ke dashboard + flash message sukses
        return redirect('/dashboard')->with('success', 'Testimoni berhasil dikirim!');
    }

    // Halaman list testimoni (opsional untuk dashboard)
    public function list()
    {
        $testimonis = Testimoni::latest()->paginate(10);
        return view('testimoni.index', compact('testimonis'));
    }
}
