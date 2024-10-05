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
        Schema::create('recordatorio', function (Blueprint $table) {
            $table->id();
            $table->string('nom_recordatorio'); 
            $table->string('tiempo_restante');
            $table->string('email'); 
            $table->foreignId('id_tarjetas')->constrained('tarjeta')->onDelete('cascade');    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recordatorio');
    }
};
