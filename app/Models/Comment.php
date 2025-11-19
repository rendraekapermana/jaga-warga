<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // PERBAIKAN: Tambahkan 'user_id' dan 'content' di sini
    protected $fillable = ['content', 'user_id'];

    /**
     * Komentar ini milik siapa (User).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Komentar ini ada di Post mana.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}