<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllergieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allergie', function (Blueprint $table) {
            
                    // Definire le colonne user_id e allergene_id
                    $table->unsignedBigInteger('client_id');
                    $table->unsignedBigInteger('allergene_id');
                    $table->timestamps();
                    // Definire la chiave primaria composta
                    $table->primary(['client_id', 'allergene_id']);
        
                    // Definire le chiavi esterne
                    $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
                    $table->foreign('allergene_id')->references('id')->on('allergeni')->onDelete('cascade');
                    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('allergie');
    }
}
