<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelpRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'extra_notes',
        'region',
        'date',
        'time',
        'status',
        'help_request_category_id',
        'client_id',
        'volunteer_id',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }

    public function category()
    {
        return $this->belongsTo(HelpRequestCategory::class, 'help_request_category_id');
    }

    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
