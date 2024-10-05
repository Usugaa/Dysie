<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarjetasTable extends Migration
{
    public function up()
    {
        Schema::create('tarjetas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id')->constrained('tableros')->onDelete('cascade');
            $table->string('nom_tarjeta');
            $table->string('color');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tarjetas');
    }
}