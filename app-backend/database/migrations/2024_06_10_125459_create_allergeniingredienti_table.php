<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllergeniingredientiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allergeniingredienti', function (Blueprint $table) {
            $table->id();
            $table->foreignId("ingretiente")->constrained('ingredienti')->onDelete('cascade');
            $table->foreignId("allergene")->constrained('allergeni')->onDelete('cascade');
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
        Schema::dropIfExists('allergeniingredienti');
    }
}
