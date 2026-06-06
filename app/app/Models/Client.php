<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        'personal_description',
        'status',
        'membership_active',
        'background_notes',
        'user_id',
    ];
    protected function casts(): array
    {
        return [
            'membership_active' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function helpRequests()
    {
        return $this->hasMany(HelpRequest::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function intakes()
    {
        return $this->hasMany(Intake::class);
    }

    public function favoritedVolunteers()
    {
        return $this->belongsToMany(Volunteer::class, 'client_favorite_volunteers');
    }
}
