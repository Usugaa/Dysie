<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablerosTable extends Migration
{
    public function up()
    {
        Schema::create('tableros', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('nom_tablero');
            $table->string('color');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tableros');
    }
}
