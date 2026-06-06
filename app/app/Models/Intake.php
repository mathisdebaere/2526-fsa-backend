<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Intake extends Model
{
    protected $fillable = [
        'notes',
        'document_url',
        'status',
        'user_id',
        'advisor_id',
        'appointment_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function advisor()
    {
        return $this->belongsTo(User::class, 'advisor_id');
    }
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
