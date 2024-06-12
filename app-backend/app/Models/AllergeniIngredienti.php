<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Thiagoprz\CompositeKey\HasCompositeKey;

class AllergeniIngredienti extends Model
{
    use HasFactory;
    use HasCompositeKey;

    protected $table = "allergeni_ingrediente";
    protected $primaryKey = ['allergeni_id', 'ingrediente_id'];
    protected $fillable = ['allergeni_id', 'ingrediente_id'];

    public $incrementing = false;
}
