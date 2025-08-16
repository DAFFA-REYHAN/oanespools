<?php

namespace App\Http\Controllers;
use App\Models\Hero;
use App\Models\Gallery;
use App\Models\Layanan;
use App\Models\Artikel;

abstract class Controller
{
    function index()
    {
        $hero=Hero::first();
        $galleries=Gallery::all();
        $layanans=Layanan::all();
        $artikels=Artikel::all();
        return view('index');
    }
}
