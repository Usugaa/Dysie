<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_usu');
            $table->string('apellidos_usu');
            $table->string('email')->unique();
            $table->string('password');
            $table->date('fecha_nacimiento');
            $table->string('grado');
            $table->boolean('membresia')->default(false);
            $table->rememberToken(); // Agrega esta línea para el remember_token
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

