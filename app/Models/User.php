<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'gender',
        'date_of_birth',
        'phone_number', // Ensure this is here if you use it
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // =================================================================
    // RELATIONS FOR COMMUNITY FEATURE
    // =================================================================

    /**
     * User has many Posts (Community).
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class); // CORRECTED: Points to Post model
    }

    /**
     * User has many Comments.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * User has many Likes.
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    // ===============================================
    // RELATIONS FOR CHAT
    // ===============================================

    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    // ===============================================
    // RELATION FOR REPORTS (CRITICAL FIX)
    // ===============================================
    
    /**
     * User has many Reports (History).
     * This must point to the Report model, NOT Post.
     */
    public function reports(): HasMany
    {
        return $this->hasMany(Report::class); // CORRECTED: Points to Report model
    }
}