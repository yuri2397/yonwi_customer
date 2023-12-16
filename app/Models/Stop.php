<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stop extends Model
{
    use HasFactory;

    protected $fillable = [
        "latitude",
        "longitude",
        "traject_id"
    ];

    protected $hidden = [
        "created_at",
        "updated_at",
        "traject_id"
    ];
}
