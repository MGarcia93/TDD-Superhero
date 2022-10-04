<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Superhero extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'history', 'creator'];
    function superpowers()
    {
        return $this->belongsToMany(Superpower::class, 'superpowers_superheroes');
    }
}
