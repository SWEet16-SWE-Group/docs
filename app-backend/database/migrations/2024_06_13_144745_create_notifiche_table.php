<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificheTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifiche', function (Blueprint $table) {
            $table->id();
            $table->enum('lettura', ['NON LETTO','LETTO'])->default('NON LETTO');
            $table->integer('prenotazione')->nullable();
            $table->integer('ordinazione')->nullable();
            $table->integer('invito')->nullable();
            $table->enum('significato', [
                'PRENOTAZIONE CREATA',
                'PRENOTAZIONE STATO',
                'PRENOTAZIONE CONTO',
                'PRENOTAZIONE CANCELLATA',
                'INVITO ACCETTATO',
                'INVITO PAGATO',
                'ORDINAZIONE CREATA',
                'ORDINAZIONE CANCELLATA',
                'ORDINAZIONE PAGATA',
            ]);
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
        Schema::dropIfExists('notifiche');
    }
}
