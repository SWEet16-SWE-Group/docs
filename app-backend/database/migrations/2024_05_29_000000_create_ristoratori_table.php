<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRistoratoriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ristoratori', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user")->constrained('users')->onDelete('cascade');
            $table->enum('cucina', ['Italiana','Cinese','Giapponese', 'Messicana', 'Indiana', 'Meditteranea']);
            $table->string("nome")->unique();
            $table->string("indirizzo")->unique();
            $table->string("telefono")->unique();
            $table->integer("capienza")->unsigned();
            $table->string("orario");
            $table->timestamp('updated_at');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ristoratori');
    }
}
