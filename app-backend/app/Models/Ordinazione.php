<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordinazione extends Model {
    use HasFactory;

    protected $table = "ordinazioni";
    protected $fillable = ['invito', 'pietanza', 'pagamento'];

    public function invito() {
        return $this->belongsTo(Invito::class, 'invito');
    }

    public function pietanza() {
        return $this->belongsTo(Pietanza::class, 'pietanza');
    }

}
