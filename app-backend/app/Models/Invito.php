<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invito extends Model
{
    use HasFactory;

    protected $table = "inviti";
    protected $fillable = [
        'prenotazione',
        'cliente',
    ];

    public function prenotazione() {
        return $this->belongsTo(Prenotazione::class, 'prenotazione');
    }

    public function cliente() {
        return $this->belongsTo(Client::class, 'cliente');
    }
}
