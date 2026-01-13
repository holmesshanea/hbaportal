<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    public const STATUS_OPEN = 'open';
    public const STATUS_CLOSED = 'closed';

    protected $fillable = [
        'event_type',
        'status',
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

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    protected $attributes = [
        'event_type' => 'retreat',
        'status' => self::STATUS_OPEN,
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

    public function closeIfFull(): bool
    {
        if ($this->status === self::STATUS_CLOSED || is_null($this->capacity)) {
            return false;
        }

        $goingCount = $this->users()
            ->wherePivot('status', 'going')
            ->count();

        if ($goingCount >= $this->capacity) {
            $this->update(['status' => self::STATUS_CLOSED]);

            return true;
        }

        return false;
    }



}
