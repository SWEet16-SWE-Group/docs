<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllergeniIngredienteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allergeni_ingrediente', function (Blueprint $table) {
            $table->id();
            $table->foreignId("allergeni_id")->constrained('allergeni')->onDelete('cascade');
            $table->foreignId("ingrediente_id")->constrained('ingredienti')->onDelete('cascade');
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
        Schema::dropIfExists('allergeni_ingrediente');
    }
}
