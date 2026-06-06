<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'start_date',
        'end_date',
        'amount',
        'status',
        'paid_at',
        'client_id',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date'   => 'date',
            'paid_at'    => 'datetime',
            'amount'     => 'decimal:2',
        ];
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
