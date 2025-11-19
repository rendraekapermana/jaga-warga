<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // PERBARUI INI: Tambahkan path media ke $fillable
    protected $fillable = ['content', 'image_path', 'video_path'];

    /**
     * Post ini milik siapa (User).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Post ini punya banyak Comment.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    /**
     * Post ini punya banyak Like.
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}