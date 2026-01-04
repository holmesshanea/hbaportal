<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_type',
        'title',
        'short_description',
        'description',
        'location',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'capacity',
        'image',
    ];

    protected $attributes = [
        'event_type' => 'retreat',
    ];

     public function users()
    {
        return $this->belongsToMany(\App\Models\User::class)
            ->withPivot(['status', 'rsvped_at'])
            ->withTimestamps();
    }

    public function questions()
    {
        return $this->hasMany(\App\Models\Question::class);
    }

    /**
     * Ensure event titles are stored in proper Title Case
     */
    public function setTitleAttribute($value): void
    {
        $this->attributes['title'] = self::formatTitle($value);
    }

    private static function formatTitle($value): string
    {
        $value = trim((string) $value);
        $value = mb_strtolower($value, 'UTF-8');

        // Capitalize first letter after start, space, hyphen, or apostrophe
        return preg_replace_callback(
            "/(^|[\\s\\-'])\\p{L}/u",
            fn ($m) => mb_strtoupper($m[0], 'UTF-8'),
            $value
        );
    }



}
