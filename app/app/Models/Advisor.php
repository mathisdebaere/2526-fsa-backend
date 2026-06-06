<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advisor extends Model
{
    protected $fillable = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function intakes()
    {
        return $this->hasMany(Intake::class);
    }
}
