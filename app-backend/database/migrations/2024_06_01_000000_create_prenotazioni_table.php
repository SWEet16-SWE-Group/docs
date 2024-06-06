<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrenotazioniTable extends Migration
{
    public function up()
    {
        Schema::create('prenotazioni', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ristoratore')->constrained('ristoratori')->onDelete('cascade');
            $table->dateTime('orario');
            $table->integer('numero_inviti');
            $table->enum('divisione_conto', ['Equo', 'Proporzionale']);
            $table->enum('stato', ['Accettata', 'Rifiutata', 'In attesa'])->default('In attesa');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('prenotazioni');
    }
}
