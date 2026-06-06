<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HelpRequestCategory extends Model
{
    protected $fillable = [
        'name',
        'description',
        'icon',
    ];

    public function helpRequests()
    {
        return $this->hasMany(HelpRequest::class);
    }
}
