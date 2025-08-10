<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Display the dashboard and check if data exists
    public function index()
    {
        // Get the first Hero record (if any)
        $jumlah = Hero::first();
        return view('dashboard.dashboard', compact('jumlah'));
    }

    // Store or update the Hero data
    public function store(Request $request)
    {
        // Validate the input data
        $request->validate([
            'jumlah_proyek' => 'required|integer|min:0',
            'jumlah_pelanggan' => 'required|integer|min:0',
        ]);

        // Check if Hero data exists (update or create)
        $hero = Hero::first();

        if ($hero) {
            // If a Hero record exists, update it
            $hero->update([
                'jumlah_proyek' => $request->jumlah_proyek,
                'jumlah_pelanggan' => $request->jumlah_pelanggan,
            ]);
            return redirect()->route('dashboard')->with('success', 'Data Berhasil di Update!');
        } else {
            // If no Hero record exists, create a new one
            Hero::create([
                'jumlah_proyek' => $request->jumlah_proyek,
                'jumlah_pelanggan' => $request->jumlah_pelanggan,
            ]);
            return redirect()->route('dashboard')->with('success', 'Data Berhasil di Update!');
        }
    }
}
