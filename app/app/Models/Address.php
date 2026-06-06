<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'postal_code',
        'municipality',
        'street',
        'house_number',
        'bus',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
