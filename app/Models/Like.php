<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    // PERBAIKAN:
    // Kita ganti '$guarded' dengan '$fillable' agar konsisten
    // dan secara eksplisit mengizinkan 'user_id' untuk diisi.
    protected $fillable = ['user_id'];

    /**
     * Like ini milik siapa (User).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Like ini untuk Post mana.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}