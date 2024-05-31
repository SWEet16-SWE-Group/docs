<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
<<<<<<<< HEAD:app-backend/database/migrations/2024_05_23_124955_create_clients_table.php
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->integer('account');
========
        Schema::create('users', function (Blueprint $table) {
            $table->id()->unique();
            $table->string('email')->unique();
            $table->string('password');
>>>>>>>> mvp-main:app-backend/database/migrations/2024_05_28_000000_create_users_table.php
            $table->timestamps();

            $table->unique(['nome','id']);

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clienti');
    }
}
