<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VolunteerReview extends Model
{
    protected $fillable = [
        'content',
        'appointment_id',
        'volunteer_id',
        'client_id',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
