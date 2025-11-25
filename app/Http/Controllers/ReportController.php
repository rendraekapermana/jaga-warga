<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Tambahkan Log untuk debugging
use App\Models\Report;
use App\Mail\ReportSubmitted;

class ReportController extends Controller
{
    public function showStep1()
    {
        $reportData = Session::get('report_data', []);
        return view('report-step1', compact('reportData'));
    }

    public function storeStep1(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'place_of_birth' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'home_address' => 'required|string|min:10',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|min:10|max:15',
        ]);

        Session::put('report_data', $validatedData);

        return redirect()->route('report.step2.show');
    }

    public function showStep2()
    {
        if (!Session::has('report_data')) {
            return redirect()->route('report.step1.show')->withErrors('Silakan isi data diri Anda terlebih dahulu.');
        }
        $reportData = Session::get('report_data', []);
        return view('report-step2', compact('reportData'));
    }

    public function storeStep2(Request $request)
    {
        // 1. Cek Session Step 1
        if (!Session::has('report_data')) {
            return redirect()->route('report.step1.show')->withErrors('Sesi Anda telah berakhir. Silakan isi data diri Anda lagi.');
        }

        // 2. Cek Login (Wajib)
        // Jika user tidak login, redirect ke login page dengan pesan error
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Sesi login Anda habis. Silakan login kembali untuk menyimpan laporan.');
        }

        // 3. Validasi Input Step 2
        $request->validate([
            'incident_type' => 'required|string|max:255',
            'incident_date' => 'required|date',
            'incident_time' => 'required', 
            'incident_location' => 'required|string|max:255',
            'description' => 'required|string|min:20',
            'evidence_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,mp4|max:10240',
            'is_anonymous' => 'required|string|in:yes,no',
        ]);

        // Ambil data session
        $step1Data = Session::get('report_data');

        // PROSES UPLOAD FILE
        $evidencePath = null;
        if ($request->hasFile('evidence_file')) {
            try {
                $file = $request->file('evidence_file');
                $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
                
                // Simpan ke disk 'public' di folder 'reports'
                // Hasilnya: "reports/17325123_namafile.jpg"
                $evidencePath = $file->storeAs('reports', $filename, 'public'); 
            } catch (\Exception $e) {
                Log::error("File Upload Error: " . $e->getMessage());
                return back()->withInput()->withErrors(['evidence_file' => 'Gagal mengupload file. Silakan coba lagi.']);
            }
        }

        // PROSES SIMPAN DATABASE
        try {
            // Gabungkan data secara manual agar lebih aman dan terkontrol
            $report = Report::create([
                // Identitas User (Wajib)
                'user_id' => Auth::id(), 
                'status' => 'Terkirim',

                // Data Step 1 (Dari Session)
                'first_name' => $step1Data['first_name'],
                'last_name' => $step1Data['last_name'],
                'place_of_birth' => $step1Data['place_of_birth'],
                'date_of_birth' => $step1Data['date_of_birth'],
                'home_address' => $step1Data['home_address'],
                'email' => $step1Data['email'],
                'phone_number' => $step1Data['phone_number'],

                // Data Step 2 (Langsung dari Request Input)
                'incident_type' => $request->input('incident_type'),
                'incident_date' => $request->input('incident_date'),
                'incident_time' => $request->input('incident_time'),
                'incident_location' => $request->input('incident_location'),
                'description' => $request->input('description'), // Ambil deskripsi langsung
                'is_anonymous' => $request->input('is_anonymous'),
                
                // Path File
                'evidence_file_path' => $evidencePath, // Gunakan path yang baru diupload
            ]);

            Log::info("Laporan baru berhasil dibuat ID: " . $report->id . " oleh User ID: " . Auth::id());

        } catch (\Exception $e) {
            // Jika gagal simpan DB, hapus file yang terlanjur diupload
            if ($evidencePath) {
                Storage::disk('public')->delete($evidencePath);
            }
            Log::error("Database Save Error: " . $e->getMessage());
            return back()->withInput()->withErrors(['db_error' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()]);
        }

        // EMAIL NOTIFIKASI (Opsional)
        // Kita bungkus try-catch agar error email tidak membatalkan laporan sukses
        try {
            $dummyPoliceEmail = config('mail.mail_report_to_address');
            if ($dummyPoliceEmail) {
                // Siapkan data array untuk email view
                $emailData = array_merge($step1Data, $request->all(), ['evidence_file_path' => $evidencePath]);
                Mail::to($dummyPoliceEmail)->send(new ReportSubmitted($emailData));
            }
        } catch (\Exception $e) {
            Log::error("Email Sending Error: " . $e->getMessage());
        }

        // Hapus session
        Session::forget('report_data');

        return redirect()->route('report.success');
    }

    public function listAllReports()
    {
        $reports = Report::orderBy('created_at', 'desc')->get();
        return redirect(route('home'))->with('status', 'Halaman reports index belum dibuat.');
    }
}