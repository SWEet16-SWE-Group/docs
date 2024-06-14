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
                //risto
                'PRENOTAZIONE CREATA',
                'PRENOTAZIONE CONTO',
                'ORDINAZIONE CREATA',
                'ORDINAZIONE PAGATA',
                'INVITO PAGATO',

                //cli
                'PRENOTAZIONE STATO',
                'INVITO ACCETTATO',
            ]);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
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
