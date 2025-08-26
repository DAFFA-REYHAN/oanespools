<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all gallery items
        $galleries = Gallery::all();

        // Count the total number of gallery items
        $galleryCount = Gallery::count();

        // Count the number of images and videos
        $imageCount = Gallery::where('type', 'like', 'gambar%')->count(); // Count images
        $videoCount = Gallery::where('type', 'like', 'video%')->count(); // Count videos

        $images = Gallery::where('type', 'like', 'gambar%')->get();
        $videos = Gallery::where('type', 'like', 'video%')->get();

        // Pass the data to the view
        return view('dashboard.gallery.gallery', compact('galleries', 'galleryCount', 'imageCount', 'videoCount', 'images', 'videos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validationRules = [
            'name' => 'required|string|max:255', // Title of the video or image
            'type' => 'required|in:video,gambar', // Must be either 'video' or 'gambar'
        ];

        // Add specific validation based on type
        if ($request->type == 'video') {
            $validationRules['video_file'] = 'required|file|mimes:mp4,avi,mov,wmv,flv,mkv,webm,m4v|max:102400'; // Max 100MB
        } elseif ($request->type == 'gambar') {
            $validationRules['path'] = 'required|file|mimes:jpeg,png,jpg,gif,svg,webp|max:10240'; // Max 10MB
        }

        $request->validate($validationRules);

        $filePath = null;

        // Handle video file or image file upload
        if ($request->type == 'video') {
            // Handle video file upload
            if ($request->hasFile('video_file')) {
                $video = $request->file('video_file');

                // Get the current date to add to the file name
                $currentDate = Carbon::now()->format('Y-m-d_H-i-s'); // Format: YYYY-MM-DD_HH-MM-SS

                // Generate the new file name using the title and the current date
                $newFileName = strtolower(str_replace(' ', '_', $request->name)) . '_' . $currentDate . '.' . $video->getClientOriginalExtension();

                // Store the video with the new name
                $filePath = $video->storeAs('Gallery/Videos', $newFileName, 'public'); // Save in the 'Gallery/Videos' directory
            } else {
                return back()->with('error', 'No video file uploaded.');
            }
        } elseif ($request->type == 'gambar') {
            // Handle image upload
            if ($request->hasFile('path')) {
                $image = $request->file('path');

                // Get the current date to add to the file name
                $currentDate = Carbon::now()->format('Y-m-d_H-i-s'); // Format: YYYY-MM-DD_HH-MM-SS (updated to match video format)

                // Generate the new file name using the title and the current date
                $newFileName = strtolower(str_replace(' ', '_', $request->name)) . '_' . $currentDate . '.' . $image->getClientOriginalExtension();

                // Store the image with the new name
                $filePath = $image->storeAs('Gallery/Images', $newFileName, 'public'); // Save in the 'Gallery/Images' directory
            } else {
                return back()->with('error', 'No image uploaded.');
            }
        }

        // Save the data in the database
        try {
            Gallery::create([
                'name' => $request->name, // Video title or image name
                'type' => $request->type, // Either 'video' or 'gambar'
                'path' => $filePath, // Store file path for both video and image
                'description' => $request->description ?? null, // Optional description field
            ]);

            // Return success with a redirect
            if ($request->type == 'video') {
                return redirect()->route('gallery')->with('success', 'Video Berhasil Ditambahkan');
            } else {
                return redirect()->route('gallery')->with('success', 'Gambar Berhasil Ditambahkan');
            }
        } catch (\Exception $e) {
            // If database save fails, delete the uploaded file to prevent orphaned files
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            return back()->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGalleryRequest $request, Gallery $gallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the gallery item by ID
        $galleryItem = Gallery::findOrFail($id);

        // Delete the file from the storage (if it's an image)
        if ($galleryItem->type === 'gambar' && $galleryItem->path) {
            // Delete the image from storage
            \Storage::disk('public')->delete($galleryItem->path);
        }

        // Delete the gallery item from the database
        $galleryItem->delete();

        // Redirect with success message
        return back()->with('success', 'Gallery item deleted successfully!');
    }
}
