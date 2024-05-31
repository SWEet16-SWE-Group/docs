<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ristoratore extends Model
{
    use HasFactory;

    protected $table = "ristoratori";
    protected $fillable = ['user', 'nome', 'indirizzo', 'telefono'];

    public function user() {
        return $this->belongsTo(User::class, 'user');
    }
}
