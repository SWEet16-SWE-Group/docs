<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable=['id','account','nome'];

    public function allergie() : BelongsToMany
    {
        return $this->belongsToMany(Allergeni::class);
    }

    public function user() {
        return $this->belongsTo(User::class, 'user');
    }

    protected $table='clienti';
}
