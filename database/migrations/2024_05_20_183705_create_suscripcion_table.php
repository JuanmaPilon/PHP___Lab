<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuscripcionTable extends Migration
{
    public function up()
    {
        Schema::create('suscripcion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('anuncio_id');
            $table->date('fechaIni');
            $table->date('fechaFin');
            $table->boolean('activa');
            $table->integer('precio');
            $table->timestamps();

            $table->foreign('cliente_id')->references('id')->on('cliente')->onDelete('cascade');
            $table->foreign('anuncio_id')->references('id')->on('anuncio')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('suscripcion');
    }
};
