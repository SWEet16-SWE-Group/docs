<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ristoratore extends Model
{
    use HasFactory;

    protected $table = "ristoratori";
    protected $fillable = ['user', 'cucina', 'nome', 'indirizzo', 'telefono', 'capienza', 'orario'];

    public function user() {
        return $this->belongsTo(User::class, 'user');
    }

    public function cucina() {
    return $this->hasOne(CucinaRistorante::class,'Id_Ristoratore');
}
}
