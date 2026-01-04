<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'expect',
        'suffer',
        'allergies',
        'concerns',
        'conduct',
    ];

    protected $attributes = [
        'suffer'    => 'None',
        'allergies' => 'None',
        'concerns'  => 'None',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
