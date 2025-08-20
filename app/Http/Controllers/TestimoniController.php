<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimoni;

class TestimoniController extends Controller
{
    // Simpan data dari form (frontend)
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'domisili' => 'required|string|max:100',
            'pesan' => 'required|string|max:500',
        ]);

        Testimoni::create($request->all());

        return redirect()->back()->with('success', 'Terima kasih atas testimoni Anda!');
    }

    // Tampilkan testimoni untuk publik (frontend)
    public function index()
    {
        $testimonis = Testimoni::latest()->take(6)->get();
        return view('index', compact('testimonis'));
    }

    // Tampilkan semua testimoni di dashboard (admin)
    public function dashboard()
    {
        $testimonis = Testimoni::latest()->paginate(10);
        return view('dashboard.testimoni.testimoni', compact('testimonis'));
    }

    public function destroy($id)
    {
        $testimoni = Testimoni::findOrFail($id);
        $testimoni->delete();

        return redirect()->route('testimoni')
                        ->with('success', 'Testimoni berhasil dihapus');
    }


}
