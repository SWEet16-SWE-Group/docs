<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngredientiTable extends Migration
{
    public function up()
    {
        Schema::create('ingredienti', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ristoratore')->constrained('ristoratori')->onDelete('cascade');
            $table->string('nome');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ingredienti');
    }
}