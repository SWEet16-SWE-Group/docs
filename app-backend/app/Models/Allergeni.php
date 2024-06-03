<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Allergeni extends Model
{
    use HasFactory;

    protected $table='allergeni';
    public function clients() : BelongsToMany {
        return $this->belongsToMany(Client::class);
    }
    public $incrementing = true;
}
