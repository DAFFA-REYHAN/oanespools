<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RatingController extends Controller
{
    function index() {
        return view('dashboard.rating.rating');
    }
}
