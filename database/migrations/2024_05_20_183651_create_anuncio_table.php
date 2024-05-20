<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnuncioTable extends Migration
{
    public function up()
    {
        Schema::create('anuncio', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->string('tipo');
            $table->boolean('disponible');
            $table->string('imagen');
            $table->timestamps();

            $table->foreign('cliente_id')->references('id')->on('cliente')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('anuncio');
    }
};