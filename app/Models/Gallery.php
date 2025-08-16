<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'path'];

    // Scope untuk tipe tertentu
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Scope untuk video
    public function scopeVideo($query)
    {
        return $query->where('type', 'video');
    }

    // Scope untuk gambar
    public function scopeImage($query)
    {
        return $query->where('type', 'gambar');
    }

    // Accessor untuk menentukan apakah ini YouTube
    public function getIsYoutubeAttribute()
    {
        return $this->type === 'video' && $this->isYouTubeUrl($this->path);
    }

    // Accessor untuk URL lengkap
    public function getFullUrlAttribute()
    {
        if ($this->is_youtube) {
            return $this->path; // Sudah URL lengkap
        }

        return Storage::url($this->path);
    }

    // Accessor untuk thumbnail YouTube
    public function getThumbnailUrlAttribute()
    {
        if ($this->is_youtube) {
            return $this->getYouTubeThumbnail();
        }

        return null; // Untuk video lokal, bisa ditambahkan logic thumbnail
    }

    // Accessor untuk YouTube embed URL
    public function getEmbedUrlAttribute()
    {
        if (!$this->is_youtube) {
            return null;
        }

        return $this->convertToEmbedUrl($this->path);
    }

    // Helper untuk mendapatkan YouTube thumbnail
    private function getYouTubeThumbnail()
    {
        $patterns = ['/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', '/youtu\.be\/([a-zA-Z0-9_-]+)/', '/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/'];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $this->path, $matches)) {
                return "https://img.youtube.com/vi/{$matches[1]}/maxresdefault.jpg";
            }
        }

        return null;
    }

    // Helper untuk convert ke embed URL
    private function convertToEmbedUrl($url)
    {
        $patterns = ['/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', '/youtu\.be\/([a-zA-Z0-9_-]+)/', '/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/'];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return "https://www.youtube.com/embed/{$matches[1]}?enablejsapi=1";
            }
        }

        return $url; // fallback
    }

    // Cek apakah URL adalah YouTube
    private function isYouTubeUrl($url)
    {
        return strpos($url, 'youtube.com') !== false || strpos($url, 'youtu.be') !== false;
    }
}
