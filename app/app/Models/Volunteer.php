<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    use HasFactory;

    protected $fillable = [
        'personal_description',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function availabilities()
    {
        return $this->hasMany(Availability::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function intakes()
    {
        return $this->hasMany(Intake::class);
    }

    public function reviews()
    {
        return $this->hasMany(VolunteerReview::class);
    }

    public function categories()
    {
        return $this->belongsToMany(HelpRequestCategory::class, 'volunteer_help_request_category');
    }

    public function favoritedByClients()
    {
        return $this->belongsToMany(Client::class, 'client_favorite_volunteers');
    }
}
