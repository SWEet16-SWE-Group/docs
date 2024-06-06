<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDettagliordinazioneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dettagliordinazione', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ingrediente')->constrained('ingredienti')->onDelete('cascade');
            $table->foreignId('ordinazione')->constrained('ordinazioni')->onDelete('cascade');
            $table->enum('dettaglio', ['-', '+']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dettagliordinazione');
    }
}
