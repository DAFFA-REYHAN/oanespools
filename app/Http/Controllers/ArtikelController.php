<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $artikelCount = Artikel::count();
        return view('dashboard.artikel.artikel', compact('artikelCount'));
    }

    /**
     * Get data for DataTable
     */
    public function artikel(Request $request)
    {
        $query = Artikel::query();

        // Get total records before applying any filters
        $totalRecords = Artikel::count();

        // Apply search filter if provided
        if ($request->has('search') && !empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Get filtered records count
        $filteredRecords = $query->count();

        // Apply ordering
        if ($request->has('order')) {
            $orderColumnIndex = $request->input('order.0.column');
            $orderDirection = $request->input('order.0.dir');

            $columns = ['title', 'content', 'image', 'actions']; // Columns without ID

            if (isset($columns[$orderColumnIndex])) {
                $orderColumn = $columns[$orderColumnIndex];
                if ($orderColumn !== 'actions' && $orderColumn !== 'image') {
                    $query->orderBy($orderColumn, $orderDirection);
                }
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Apply pagination
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);

        $articles = $query->skip($start)->take($length)->get();

        // Transform data for DataTable
        $data = $articles->map(function ($artikel) {
            return [
                'id' => $artikel->id,
                'title' => $artikel->title,
                'content' => $artikel->content,
                'image' => $artikel->image ? asset('storage/' . $artikel->image) : null,
                'created_at' => $artikel->created_at ? $artikel->created_at->format('d M Y H:i') : '',
                'updated_at' => $artikel->updated_at ? $artikel->updated_at->format('d M Y H:i') : '',
            ];
        });

        return response()->json([
            'draw' => intval($request->input('draw', 1)),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.artikel.add_artikel');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate form data
            $validated = $request->validate([
                'title' => 'required|string|max:255', // title is required
                'content' => 'required|string', // content is required
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // image is nullable
            ]);

            $imagePath = null; // Default to null if no image is uploaded

            // Handle image upload if provided
            if ($request->hasFile('image')) {
                $image = $request->file('image');

                // Validate image file type and size
                if (!in_array($image->getClientOriginalExtension(), ['jpeg', 'jpg', 'png', 'gif'])) {
                    return response()->json(['success' => false, 'error' => 'File format not supported. Please upload an image file.']);
                }

                if ($image->getSize() > 2048 * 1024) {
                    // 2MB max size
                    return response()->json(['success' => false, 'error' => 'File size is too large. Maximum size is 2MB.']);
                }

                // Generate a custom file name (using current timestamp and random string)
                $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

                // Store the file in 'storage/app/public/artikel' folder with the custom name
                $imagePath = $image->storeAs('artikel', $imageName, 'public');
            }

            // Create a new article record with the validated data
            Artikel::create([
                'title' => $request->title,
                'content' => $request->content,
                'image' => $imagePath, // Store the image path (can be null if no image uploaded)
            ]);

            // Return success response
            return response()->json(['success' => true, 'message' => 'Artikel Berhasil di tambahkan!']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return response()->json(['success' => false, 'error' => 'Validation failed: ' . implode(', ', $e->errors())]);
        } catch (\Exception $e) {
            // Catch general errors (e.g., file upload failure, database issues)
            return response()->json(['success' => false, 'error' => 'An unexpected error occurred. Please try again later.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Artikel $artikel)
    {
        return view('dashboard.artikel.show', compact('artikel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Artikel $artikel)
    {
        return view('dashboard.artikel.edit_artikel', compact('artikel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            // Validasi input
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255', // title is required
                'content' => 'required|string', // content is required
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // image is optional
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

            // Cari artikel yang akan diupdate
            $artikel = Artikel::findOrFail($id);

            // Siapkan data untuk update
            $dataUpdate = [
                'title' => $request->title,
                'content' => $request->content,
            ];

            // Handle image upload if there is a new file
            if ($request->hasFile('image')) {
                $file = $request->file('image');

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
                if ($artikel->image && Storage::disk('public')->exists($artikel->image)) {
                    Storage::disk('public')->delete($artikel->image);
                }

                // Upload gambar baru
                $imageName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $imagePath = $file->storeAs('artikel', $imageName, 'public');

                if (!$imagePath) {
                    return response()->json(
                        [
                            'success' => false,
                            'error' => 'Gagal mengupload gambar.',
                        ],
                        500,
                    );
                }

                $dataUpdate['image'] = $imagePath;
            }

            // Update artikel
            $artikel->update($dataUpdate);

            return response()->json([
                'success' => true,
                'message' => 'Artikel berhasil diupdate!',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(
                [
                    'success' => false,
                    'error' => 'Artikel tidak ditemukan.',
                ],
                404,
            );
        } catch (\Exception $e) {
            // Log error for debugging
            \Log::error('Error updating artikel: ' . $e->getMessage());

            return response()->json(
                [
                    'success' => false,
                    'error' => 'Terjadi kesalahan saat mengupdate artikel. Silakan coba lagi.',
                ],
                500,
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artikel $artikel)
    {
        try {
            // Delete image if exists
            if ($artikel->image && Storage::disk('public')->exists($artikel->image)) {
                Storage::disk('public')->delete($artikel->image);
            }

            $artikel->delete();

            return response()->json([
                'success' => true,
                'message' => 'Artikel berhasil dihapus!',
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Gagal menghapus artikel: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }
}
