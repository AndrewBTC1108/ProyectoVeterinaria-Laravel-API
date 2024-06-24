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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            //usamos constrained para especificar una foreygnKey, en este caso a pet_id, el cual seria para la tabla pets
            $table->foreignId('pet_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->foreignId('hour_id')->constrained()->onDelete('cascade');
            $table->string('reason');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('status')->default(0); //1 esta completa , 0 se esta pendiente
            $table->timestamps();
            // Restricción única para evitar citas duplicadas para una mascota en la misma fecha
            $table->unique(['pet_id', 'date']);

            // Restricción única para evitar citas duplicadas en la misma fecha y hora
            $table->unique(['date', 'hour_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
