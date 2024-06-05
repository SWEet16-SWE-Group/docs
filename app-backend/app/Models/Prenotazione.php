<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prenotazione extends Model
{
    use HasFactory;

    protected $table = "prenotazioni";
    protected $fillable = [
        'cliente',
        'ristoratore',
        'orario',
        'numero_inviti',
        'divisione_conto',
    ];

    public function ristoratore() {
        return $this->belongsTo(Ristoratore::class, 'ristoratore');
    }

    public function cliente() {
        return $this->belongsTo(Client::class,'cliente');
    }
}