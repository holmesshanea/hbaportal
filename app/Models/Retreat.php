<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retreat extends Model
{
    use HasFactory;

    protected $fillable = [
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


    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class)
            ->withPivot(['status', 'rsvped_at'])
            ->withTimestamps();
    }

}
