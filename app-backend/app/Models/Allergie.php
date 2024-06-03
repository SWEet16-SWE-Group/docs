<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Thiagoprz\CompositeKey\HasCompositeKey;

class Allergie extends Model
{
    use HasFactory;
    use HasCompositeKey;

    protected $primaryKey = ['client_id', 'allergene_id'];
    protected $fillable = ['client_id', 'allergene_id'];

    public $incrementing = false;

    protected $table='allergie';
}