<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingrediente extends Model
{
    use HasFactory;

    protected $table = "ingredienti";

    protected $fillable = ['ristoratore', 'nome'];

    public function ristoratore() 
    {
        return $this->belongsTo(Ristoratore::class, 'ristoratore');
    }
}