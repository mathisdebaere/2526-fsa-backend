<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'type',
        'date',
        'start_time',
        'end_time',
        'location',
        'status',
        'volunteer_id',
        'advisor_id',
        'client_id',
        'help_request_id',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }
    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class);
    }
    public function advisor()
    {
        return $this->belongsTo(Advisor::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function helpRequest()
    {
        return $this->belongsTo(HelpRequest::class);
    }
    public function intake()
    {
        return $this->hasOne(\App\Models\Intake::class);
    }
}
