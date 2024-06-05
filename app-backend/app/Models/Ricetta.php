<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ricette extends Model
{
    use HasFactory;

    protected $table = "ricette";
    protected $fillable = ['pietanza', 'ingrediente'];

    public function pietanza()
    {
        return $this->belongsTo(Ingrediente::class, 'pietanza');
    }

    public function ingrediente()
    {
        return $this->belongsTo(Ingrediente::class, 'ingrediente');
    }

}
