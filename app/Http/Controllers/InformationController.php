<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Information;
use Illuminate\View\View;

class InformationController extends Controller
{
    /**
     * Menampilkan halaman informasi.
     */
    public function index(): View
    {
        $dummyData = [
            (object)[
                'title'       => 'Pencegahan Kekerasan Seksual',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam ac elit vitae.',
                'url'         => 'https://ykp.or.id/datainfo/materi/385',
                'image_path'  => 'https://picsum.photos/seed/prevent/600/400'
            ],
            (object)[
                'title'       => 'Dukungan untuk Korban',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque nisl eros.',
                'url'         => '#',
                'image_path'  => 'https://picsum.photos/seed/support/600/400'
            ],
            (object)[
                'title'       => 'Mengenali Tanda-Tanda Peringatan',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent nec diam.',
                'url'         => '#',
                'image_path'  => 'https://picsum.photos/seed/warning/600/400'
            ],
            (object)[
                'title'       => 'Membangun Komunitas Aman',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod.',
                'url'         => '#',
                'image_path'  => 'https://picsum.photos/seed/community/600/400'
            ],
        ];

        return view('information', [
            'informations' => collect($dummyData)
        ]);

        // $informations = Information::all();
        
        // return view('information', [
        //     'informations' => $informations
        // ]);
    }
}
