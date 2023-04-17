<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class typeressources extends Model
{
    use HasFactory;
    protected $fillable=[ 
        'nom',
        'quantites'
    ];
}
