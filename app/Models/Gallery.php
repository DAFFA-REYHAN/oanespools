<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'path',
        'thumbnail', // Hanya field thumbnail, tanpa thumbnail_type
    ];

    protected $appends = ['file_url', 'thumbnail_url'];

    public function getFileUrlAttribute()
    {
        return Storage::url($this->path);
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail ? Storage::url($this->thumbnail) : null;
    }

    // Helper method to check if has thumbnail
    public function hasThumbnail()
    {
        return !empty($this->thumbnail) && Storage::disk('public')->exists($this->thumbnail);
    }
}
