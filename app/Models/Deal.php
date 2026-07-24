<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'end_date', 'is_active',
        'badge_text', 'cta_text', 'cta_link',
    ];

    protected function casts(): array
    {
        return [
            'end_date' => 'datetime',
            'is_active' => 'boolean',
        ];
    }
}
