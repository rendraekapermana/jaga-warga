<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'status',

        // Data from Step 1
        'first_name',
        'last_name',
        'place_of_birth',
        'date_of_birth',
        'home_address',
        'email',
        'phone_number',

        // Data from Step 2
        'incident_type',
        'incident_date',
        'incident_time',      // Must exist here to be saved
        'incident_location',  // Must exist here to be saved
        'description',        // Must exist here to be saved
        'evidence_file_path', // Must exist here to be saved
        'is_anonymous',
    ];

    /**
     * Relationship to User model
     * A Report belongs to one User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}