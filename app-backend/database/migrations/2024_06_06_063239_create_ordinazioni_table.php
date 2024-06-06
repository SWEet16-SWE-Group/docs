<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdinazioniTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordinazioni', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invito')->constrained('inviti')->onDelete('cascade');
            $table->foreignId('pietanza')->constrained('pietanze')->onDelete('cascade');
            $table->enum('pagamento', ['NON PAGATO', 'PAGATO'])->default('NON PAGATO');
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
        Schema::dropIfExists('ordinazioni');
    }
}
