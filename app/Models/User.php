<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $guarded = ['profile_confirmed'];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'branch',
        'gender',
        'phone',
        'emergency_contact_name',
        'emergency_contact_phone',
        'town',
        'state',
        'zipcode',
        'profile_confirmed',
        'id_confirmed',
        'status_confirmed',
        'image'


    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function events()
    {
        return $this->belongsToMany(Event::class)
            ->withPivot(['status', 'rsvped_at'])
            ->withTimestamps();
    }

    public function retreats()
    {
        return $this->belongsToMany(Retreat::class)
            ->withPivot(['status', 'rsvped_at'])
            ->withTimestamps();
    }

    public function isProfileComplete(): bool
    {
        $requiredFields = [
            'name',
            'email',
            'password',
            'role',
            'status',
            'branch',
            'gender',
            'phone',
            'emergency_contact_name',
            'emergency_contact_phone',
            'town',
            'state',
            'zipcode',
            'image',
        ];

        foreach ($requiredFields as $field) {
            if (blank($this->{$field})) {
                return false;
            }
        }

        return true;
    }


}

