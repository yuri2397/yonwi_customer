<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traject extends Model
{
    use HasFactory;
     
    protected $fillable = [
        "line",
        "from",
        "to",
        "distance"
    ];

    protected $hidden = [
        "created_at",
        "updated_at",
    ];

    public function stops()
    {
        return $this->hasMany(Stop::class);
    }

    public function points()
    {
        return $this->hasMany(TrajectPoint::class);
    }

    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
