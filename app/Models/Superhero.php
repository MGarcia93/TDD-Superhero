<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Superhero extends Model
{
    use HasFactory;
    function superpowers()
    {
        return $this->belongsToMany(Superpower::class, 'superpowers_superheroes');
    }
}
