<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvitiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inviti', function (Blueprint $table) {
            $table->id();
            $table->foreignId("cliente")->constrained('clients')->onDelete('cascade');
            $table->foreignId("prenotazione")->constrained('prenotazioni')->onDelete('cascade');
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
        Schema::dropIfExists('inviti');
    }
}
