<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pietanza extends Model
{
    use HasFactory;
    
    protected $table = "pietanze";

    protected $fillable = ['ristoratore', 'nome'];

    public function ristoratore()
    {
        return $this->belongsTo(Ristoratore::class, 'ristoratore');
    }

    public function ingredienti() {
        return $this->belongsToMany(Ingrediente::class,'ricette','pietanza','ingrediente');
    }
}