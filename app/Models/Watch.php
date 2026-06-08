<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Watch extends Model
{
    use HasFactory;

    // Yeh saare fields database mein data bharne ke liye allow hain
    protected $fillable = [
        'name',
        'brand',
        'description',
        'price',
        'stock',
        'image'
    ];
}