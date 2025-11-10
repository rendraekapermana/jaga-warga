<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     * Ini mengizinkan semua kolom untuk diisi via Report::create()
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     * Ini untuk memastikan 'is_anonymous' jadi true/false
     * dan 'incident_date' menjadi objek tanggal.
     * @var array
     */
    protected $casts = [
        'is_anonymous' => 'boolean',
        'incident_date' => 'date',
        'date_of_birth' => 'date',
    ];

    /**
     * Definisikan relasi: Laporan ini dimiliki oleh seorang User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}