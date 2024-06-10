<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllergeniIngredienti extends Model
{
    use HasFactory;

    protected $table = "allergeni_ingredienti";
    protected $fillable = [
        'ingrediente',
        'allergene',
    ];

    public function ingrediente() {
        return $this->belongsTo(Ingrediente::class, 'ingrediente');
    }

    public function allergene() {
        return $this->belongsTo(Allergeni::class, 'allergene');
    }

}
