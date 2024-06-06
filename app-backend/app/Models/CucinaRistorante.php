<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class CucinaRistorante extends Model
{   
    use HasFactory;
    
    protected $fillable = ['Cucina' , 'Id_Ristoratore'];

    protected $table = 'cucina_ristorante';
    public function ristorante() {
        return $this->belongsTo(Ristoratore::class,'Id_Ristoratore');
    }
    
    protected $primaryKey = 'ID_Cucina';
}