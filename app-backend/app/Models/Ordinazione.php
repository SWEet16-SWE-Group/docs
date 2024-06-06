<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordinazione extends Model {
    use HasFactory;

    protected $table = "ordinazioni";
    protected $fillable = ['invito', 'prenotazione', 'pietanza', 'pagamento'];

    public function invito() {
        return $this->belongsTo(Invito::class, 'invito');
    }

    public function prenotazione() {
        return $this->belongsTo(Prenotazione::class, 'prenotazione');
    }

    public function pietanza() {
        return $this->belongsTo(Pietanza::class, 'pietanza');
    }

}
