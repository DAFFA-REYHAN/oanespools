<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    // Define the table name (optional if the table name follows Laravel's naming conventions)
    protected $table = 'layanans';

    // Define the fillable columns to protect against mass-assignment vulnerabilities
    protected $fillable = [
        'nama_layanan', // Service name
        'gambar', // Image (nullable)
        'deskripsi', // Description (nullable)
    ];
}
