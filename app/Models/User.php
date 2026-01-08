<?php

namespace App\Models;

use Attribute;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

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
        'last_name',
        'first_name',
        'email',
        'password',
        'role',
        'status',
        'branch',
        'combat',
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
        'image',
         'email_verified_at',


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
            'combat' => 'boolean',
            'profile_confirmed' => 'boolean',
        ];
    }

    public function events()
    {
        return $this->belongsToMany(Event::class)
            ->withPivot(['status', 'rsvped_at'])
            ->withTimestamps();
    }

    public function isAdminOrSuper(): bool
    {
        if (method_exists($this, 'hasAnyRole')) {
            return $this->hasAnyRole(['admin', 'super', 'Admin', 'Super', 'super user', 'Super User']);
        }

        if (method_exists($this, 'hasRole')) {
            return $this->hasRole('admin')
                || $this->hasRole('super')
                || $this->hasRole('Admin')
                || $this->hasRole('Super');
        }

        $roleValue = strtolower(trim((string) ($this->role ?? '')));

        return in_array($roleValue, ['admin', 'super', 'super user'], true);
    }

public function setFirstNameAttribute($value): void
{
    $this->attributes['first_name'] = self::formatPersonName($value);
}

    public function setLastNameAttribute($value): void
    {
        $this->attributes['last_name'] = self::formatPersonName($value);
    }

    private static function formatPersonName($value): string
    {
        $value = trim((string) $value);
        $value = mb_strtolower($value, 'UTF-8');

        // Capitalize any letter that follows start, space, hyphen, or apostrophe
        return preg_replace_callback(
            "/(^|[\\s\\-'])\\p{L}/u",
            fn ($m) => mb_strtoupper($m[0], 'UTF-8'),
            $value
        );
    }
    public function isProfileComplete(): bool
    {
        $requiredFields = [
            'last_name',
            'first_name',
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

    public function questions()
    {
        return $this->hasMany(\App\Models\Question::class);
    }


}
