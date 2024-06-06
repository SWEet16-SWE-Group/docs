<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DettagliOrdinazione extends Model
{
    use HasFactory;

    protected $table = 'dettagliordinazione';
    protected $fillable = ['ordinazione','pietanza'];

    public function ordinazione() {
        return $this->belongsTo(Ordinazione::class, 'ordinazione');
    }

    public function pietanza() {
        return $this->belongsTo(Pietanza::class, 'pietanza');
    }

}
