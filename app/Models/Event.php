<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'speaker',
        'location',
        'total_seats',
    ];

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}
