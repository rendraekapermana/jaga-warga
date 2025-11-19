<?php

namespace App\Http\Controllers;

use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman utama (homepage).
     */
    public function index()
    {
        $user = Auth::user(); 

        // Diubah ke 'superadmin' (huruf kecil)
        if ($user && $user->role === 'superadmin') {
            return redirect()->route('admin.dashboard');
        }

        // Ambil 5 informasi terbaru untuk ditampilkan di homepage
        $informations = Information::latest()->take(5)->get();

        // Tampilkan view 'home' dan kirim data 'informations'
        return view('home', compact('informations'));
    }
}