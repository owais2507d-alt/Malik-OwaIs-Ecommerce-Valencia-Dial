<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'subtitle', 'description', 'cta_text', 'cta_link', 'image', 'is_active', 'order'];
}
