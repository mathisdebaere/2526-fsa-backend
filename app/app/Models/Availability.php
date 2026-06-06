<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'time_of_day',
        'volunteer_id',
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
}
