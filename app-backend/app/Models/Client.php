<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable=['id','account','nome'];

    public function allergie() : BelongsToMany
    {
        return $this->belongsToMany(Allergeni::class);
    }

    protected $table='clients';
}
