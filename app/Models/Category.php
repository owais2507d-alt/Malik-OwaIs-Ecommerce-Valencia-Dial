<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Aapki migration ke mutabiq fillable fields
    protected $fillable = ['name', 'slug', 'status'];

    /**
     * Relationship: Ek category ke andar bohot saari watches ho sakti hain.
     * (Agar aapki watches table mein category_id majood hai toh yeh relation perfectly kaam karega)
     */
    public function watches()
    {
        return $this->hasMany(Watch::class);
    }
}