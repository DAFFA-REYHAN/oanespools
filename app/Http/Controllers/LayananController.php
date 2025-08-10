<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LayananController extends Controller
{
    public function index()
    {
        // Get all layanan data from the database
        $layanans = Layanan::all(); // Fetch all services

        // Count the total number of layanan records
        $layananCount = Layanan::count();

        // Pass both the $layanans and $layananCount to the view
        return view('dashboard.layanan.layanan', compact('layanans', 'layananCount'));
    }

    public function add_layanan()
    {
        return view('dashboard.layanan.add_layanan');
    }

    public function edit($id)
    {
        $layanan = Layanan::findOrFail($id);

        return view('dashboard.layanan.edit_layanan', compact('layanan'));
    }

    public function store(Request $request)
    {
        try {
            // Validate form data
            $validated = $request->validate([
                'nama_layanan' => 'required|string|max:255', // nama_layanan is required
                'gambar' => 'nullable|file|mimes:jpeg,jpg,png,gif,pdf|max:5120', // gambar is nullable
                'deskripsi' => 'nullable|string', // deskripsi is nullable
            ]);

            // Handle image upload if provided
            $path = null; // Default to null if no image is uploaded
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');

                // Validate image file type and size
                if (!in_array($file->getClientOriginalExtension(), ['jpeg', 'jpg', 'png', 'gif', 'pdf'])) {
                    return response()->json(['success' => false, 'error' => 'File format not supported. Please upload an image or PDF file.']);
                }

                if ($file->getSize() > 5120 * 1024) {
                    // 5MB max size
                    return response()->json(['success' => false, 'error' => 'File size is too large. Maximum size is 5MB.']);
                }

                // Generate a custom file name (using nama_layanan and current timestamp)
                $filename = $request->nama_layanan . '-' . now()->timestamp . '.' . $file->getClientOriginalExtension();
                // Store the file in 'storage/app/public/layanans' folder with the custom name
                $path = $file->storeAs('Layanan', $filename, 'public');
            }

            // Create a new service record with the validated data
            Layanan::create([
                'nama_layanan' => $request->nama_layanan,
                'gambar' => $path, // Store the custom image path
                'deskripsi' => $request->deskripsi, // Deskripsi can be null
            ]);

            // Return success response as JSON
            return response()->json(['success' => true, 'message' => 'Layanan Berhasil di tambahkan!']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return response()->json(['success' => false, 'error' => 'Validation failed: ' . implode(', ', $e->errors())]);
        } catch (\Exception $e) {
            // Catch general errors (e.g., file upload failure, database issues)
            return response()->json(['success' => false, 'error' => 'An unexpected error occurred. Please try again later.']);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Validasi input
            $validator = Validator::make($request->all(), [
                'nama_layanan' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'gambar' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:5120', // 5MB max
            ]);

            if ($validator->fails()) {
                return response()->json(
                    [
                        'success' => false,
                        'error' => $validator->errors()->first(),
                    ],
                    422,
                );
            }

            // Cari layanan yang akan diupdate
            $layanan = Layanan::findOrFail($id);

            // Siapkan data untuk update
            $dataUpdate = [
                'nama_layanan' => $request->nama_layanan,
                'deskripsi' => $request->deskripsi,
            ];

            // Handle upload gambar jika ada file baru
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');

                // Validasi file
                if (!$file->isValid()) {
                    return response()->json(
                        [
                            'success' => false,
                            'error' => 'File gambar tidak valid.',
                        ],
                        422,
                    );
                }

                // Hapus gambar lama jika ada
                if ($layanan->gambar && Storage::disk('public')->exists($layanan->gambar)) {
                    Storage::disk('public')->delete($layanan->gambar);
                }

                // Upload gambar baru
                $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('layanan', $fileName, 'public');

                if (!$filePath) {
                    return response()->json(
                        [
                            'success' => false,
                            'error' => 'Gagal mengupload gambar.',
                        ],
                        500,
                    );
                }

                $dataUpdate['gambar'] = $filePath;
            }

            // Update layanan
            $layanan->update($dataUpdate);

            return response()->json([
                'success' => true,
                'message' => 'Layanan berhasil diupdate!',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(
                [
                    'success' => false,
                    'error' => 'Layanan tidak ditemukan.',
                ],
                404,
            );
        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('Error updating layanan: ' . $e->getMessage());

            return response()->json(
                [
                    'success' => false,
                    'error' => 'Terjadi kesalahan saat mengupdate layanan. Silakan coba lagi.',
                ],
                500,
            );
        }
    }

    public function destroy($id)
    {
        try {
            $layanan = Layanan::findOrFail($id);

            // Hapus gambar jika ada
            if ($layanan->gambar && Storage::disk('public')->exists($layanan->gambar)) {
                Storage::disk('public')->delete($layanan->gambar);
            }

            $layanan->delete();

            return response()->json([
                'success' => true,
                'message' => 'Layanan berhasil dihapus!',
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'error' => 'Gagal menghapus layanan.',
                ],
                500,
            );
        }
    }
}
