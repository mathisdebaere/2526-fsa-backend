<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'email',
        'password',
        'phone',
        'profile_photo_url',
        'role',
        'privacy_agreement',
        'privacy_agreement_timestamp',
        'account_status',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'privacy_agreement' => 'boolean',
            'date_of_birth' => 'date',
            'privacy_agreement_timestamp' => 'datetime',
        ];
    }

    public function getProfilePhotoUrlAttribute(?string $value): ?string
    {
        return $value ? Storage::disk('public')->url($value) : null;
    }
    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function client()
    {
        return $this->hasOne(Client::class);
    }
    public function volunteer()
    {
        return $this->hasOne(Volunteer::class);
    }

    public function advisor()
    {
        return $this->hasOne(Advisor::class);
    }
}
