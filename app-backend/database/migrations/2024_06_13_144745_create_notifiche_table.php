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
            $table->foreignId('prenotazione')->nullable()->constrained('prenotazioni')->onDelete('cascade');
            $table->foreignId('ordinazione')->nullable()->constrained('ordinazioni')->onDelete('cascade');
            $table->foreignId('inviti')->nullable()->constrained('inviti')->onDelete('cascade');
            $table->enum('significato', [
                'PRENOTAZIONE CREATA',
                'PRENOTAZIONE STATO',
                'PRENOTAZIONE CONTO',
                'PRENOTAZIONE PAGAMENTO',
                'INVITO',
                'ORDINAZIONE CREATA',
                'ORDINAZIONE CANCELLATA',
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
