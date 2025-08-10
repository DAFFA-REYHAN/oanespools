<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    /** @use HasFactory<\Database\Factories\GalleryFactory> */
    use HasFactory;
    protected $table = 'galleries';

    // Define the fillable columns to protect against mass-assignment vulnerability
    protected $fillable = [
        'name',   // The name of the file
        'type',   // The file type (e.g., image/jpeg, video/mp4)
        'path',   // The path to the uploaded file
    ];

    // Optional: Define if you want to automatically handle timestamps (created_at, updated_at)
    public $timestamps = true;
}
