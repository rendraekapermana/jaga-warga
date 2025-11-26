<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report; // Pastikan Model Report di-import
use App\Models\User;   // Pastikan Model User di-import untuk consultationCount

class AdminController extends Controller
{
    public function dashboard()
    {
        // PERBAIKAN: Memastikan SEMUA variabel count dihitung dan didefinisikan
        
        $reportCount = Report::count();
        // Asumsi 'Psychologist' adalah role untuk konsultasi
        $consultationCount = User::where('role', 'Psychologist')->count(); 
        
        // Menghitung total aktivitas
        $activityCount = $reportCount + $consultationCount; // Variabel yang dibutuhkan dashboard

        // Ambil data terbaru untuk tabel ringkasan
        $reports = Report::latest()->take(5)->get();
        $consultations = User::where('role', 'Psychologist')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'activityCount', // Variabel dikirim
            'reportCount',
            'consultationCount',
            'reports',
            'consultations'
        ));
    }

    // Method yang dipanggil oleh /admin/report
    public function report()
    {
        // Menggunakan paginate() untuk halaman penuh
        $reports = Report::latest()->paginate(20); 
        return view('admin.report', compact('reports')); 
    }

    // Method yang dipanggil oleh /admin/consultation
    public function consultation()
    {
        // Mengambil semua user Psychologist
        $consultations = \App\Models\User::where('role', 'Psychologist')->get();
        return view('admin.consultation', compact('consultations'));
    }
}