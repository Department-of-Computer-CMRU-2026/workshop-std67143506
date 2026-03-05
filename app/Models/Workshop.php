<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    protected $fillable = [
        'title',
        'lecturer',
        'location',
        'capacity',
        'description',
    ];

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}
