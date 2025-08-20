<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimoni;

class TestimoniController extends Controller
{
    // Simpan data dari form (frontend)
    public function store(Request $request)
    {
        try {
            // Validasi
            $request->validate(
                [
                    'nama' => 'required|string|max:100',
                    'domisili' => 'required|string|max:100',
                    'pesan' => 'required|string|max:500',
                ],
                [
                    'nama.required' => 'Nama wajib diisi',
                    'nama.max' => 'Nama maksimal 100 karakter',
                    'domisili.required' => 'Domisili wajib diisi',
                    'domisili.max' => 'Domisili maksimal 100 karakter',
                    'pesan.required' => 'Pesan wajib diisi',
                    'pesan.max' => 'Pesan maksimal 500 karakter',
                ],
            );

            // Simpan testimoni
            $testimoni = Testimoni::create($request->all());

            // Cek apakah request AJAX atau tidak
            if ($request->ajax() || $request->wantsJson()) {
                // Response untuk AJAX
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Terima kasih atas testimoni Anda!',
                        'data' => $testimoni,
                    ],
                    201,
                );
            }

            // Response untuk form biasa (non-AJAX)
            return redirect()->back()->with('success', 'Terima kasih atas testimoni Anda!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Data yang dimasukkan tidak valid',
                        'errors' => $e->errors(),
                    ],
                    422,
                );
            }

            // Untuk form biasa, Laravel akan handle otomatis
            throw $e;
        } catch (\Exception $e) {
            // Handle general errors
            \Log::error('Error saat menyimpan testimoni: ' . $e->getMessage());

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.',
                    ],
                    500,
                );
            }

            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
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

        return redirect()->route('testimoni')->with('success', 'Testimoni berhasil dihapus');
    }
}
