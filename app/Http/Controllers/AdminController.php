<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report; // Pastikan Model Report di-import
use App\Models\User;   // Pastikan Model User di-import untuk consultationCount

class AdminController extends Controller
{
    public function dashboard()
    {
        // Hitung jumlah aktivitas (misalnya total report + total konsultasi, atau sesuai logika Anda)
        // Di sini saya asumsikan aktivitas = total report + total konsultasi
        $reportCount = Report::count();
        $consultationCount = User::where('role', 'Psychologist')->count(); // Atau hitung sesi konsultasi jika ada tabelnya
        $activityCount = $reportCount + $consultationCount;

        // Ambil data terbaru untuk tabel di dashboard
        $reports = Report::latest()->take(5)->get();
        
        // Untuk consultations, karena belum ada tabel khusus 'consultations', 
        // mungkin bisa ambil data chat terakhir atau user psikolog.
        // Contoh sementara: ambil 5 user psikolog terbaru
        $consultations = User::where('role', 'Psychologist')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'activityCount',
            'reportCount',
            'consultationCount','reports',
            'consultations'
        ));
    }

    public function report()
    {
        return view('admin.report');
    }

    public function consultation()
    {
        return view('admin.consultation');
    }
}