<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'path'];

    /**
     * Attribute yang akan ditambahkan saat toArray()/JSON
     */
    protected $appends = ['is_youtube', 'full_url', 'thumbnail_url'];

    /* ===========================
     | Scopes
     ============================*/
    public function scopeVideo($query)
    {
        return $query->where('type', 'video');
    }

    public function scopeImage($query)
    {
        return $query->where('type', 'gambar');
    }

    /* ===========================
     | Accessors
     ============================*/

    public function getIsYoutubeAttribute(): bool
    {
        return $this->type === 'video' && $this->isYouTubeUrl($this->path);
    }

    /**
     * URL siap pakai untuk video atau gambar
     * - YouTube: kembalikan original URL
     * - URL absolut lain: kembalikan apa adanya
     * - Path lokal storage: Storage::url()
     */
    public function getFullUrlAttribute(): ?string
    {
        $path = $this->path;

        if (!$path) {
            return null;
        }

        if ($this->is_youtube) {
            return $path;
        }

        if ($this->isAbsoluteUrl($path)) {
            return $path;
        }

        // path relatif → storage url
        return Storage::url($path);
    }

    /**
     * Thumbnail URL untuk YouTube video
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        if (!$this->is_youtube) {
            return null;
        }

        $id = $this->extractYouTubeId($this->path);
        if (!$id) {
            return null;
        }

        // Gunakan hqdefault.jpg untuk kompatibilitas yang lebih baik
        return "https://img.youtube.com/vi/{$id}/hqdefault.jpg";
    }

    /* ===========================
     | Helper Methods
     ============================*/

    private function isYouTubeUrl(string $url): bool
    {
        if (!$this->isAbsoluteUrl($url)) {
            return false;
        }

        $host = parse_url($url, PHP_URL_HOST) ?: '';
        $host = Str::lower($host);

        return Str::contains($host, 'youtube.com') || Str::contains($host, 'youtu.be');
    }

    private function isAbsoluteUrl(string $path): bool
    {
        return Str::startsWith($path, ['http://', 'https://', '//']);
    }

    /**
     * Ekstrak YouTube Video ID dari berbagai bentuk URL
     */
    private function extractYouTubeId(string $url): ?string
    {
        // 1) Coba parse query param ?v=
        $parsed = parse_url($url);
        if (!empty($parsed['query'])) {
            parse_str($parsed['query'], $q);
            if (!empty($q['v']) && $this->isValidYouTubeId($q['v'])) {
                return $q['v'];
            }
        }

        // 2) Cek path pattern: /embed/ID, /shorts/ID, youtu.be/ID
        $patterns = [
            '#/embed/([a-zA-Z0-9_-]{6,})#i',
            '#/shorts/([a-zA-Z0-9_-]{6,})#i',
            '#youtu\.be/([a-zA-Z0-9_-]{6,})#i'
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $m) && $this->isValidYouTubeId($m[1])) {
                return $m[1];
            }
        }

        return null;
    }

    private function isValidYouTubeId(string $id): bool
    {
        return (bool) preg_match('/^[a-zA-Z0-9_-]{6,}$/', $id);
    }
}