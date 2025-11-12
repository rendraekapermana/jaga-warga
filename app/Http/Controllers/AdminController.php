<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View; 

class AdminController extends Controller
{
    public function dashboard(): View 
    {
        $activityCount = 5090;
        $reportCount = 90;
        $consultationCount = 8;

        $reports = [
            (object)[
                'id' => '001',
                'name' => 'Syarif Muhammad',
                'created_at' => now(),
                'type' => 'Raped',
                'status' => 'Solved'
            ],
            (object)[
                'id' => '002',
                'name' => 'Syarif Muhammad',
                'created_at' => now(),
                'type' => 'Raped',
                'status' => 'Pending'
            ],
        ];

        $consultations = [
            (object)[
                'id' => '001',
                'patient_name' => 'Syarif Muhammad',
                'doctor_name' => 'Rizal Romli, S.Psi...',
                'status' => 'Solved'
            ],
             (object)[
                'id' => '002',
                'patient_name' => 'Syarif Muhammad',
                'doctor_name' => 'Rizal Romli, S.Psi...',
                'status' => 'Pending'
            ],
        ];

        return view('dashboard', [
            'activityCount'     => $activityCount,
            'reportCount'       => $reportCount,
            'consultationCount' => $consultationCount,
            'reports'           => $reports,
            'consultations'     => $consultations
        ]);
    }
}