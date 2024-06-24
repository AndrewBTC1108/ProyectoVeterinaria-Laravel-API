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
        Schema::create('medical_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pet_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->string('reasonConsult');
            $table->string('observations');
            $table->string('food');
            $table->integer('frequencyFood'); //could use an entire field to store the frequency of feeding.
            $table->timestamps();

            // Single restriction to avoid duplicate medical_histories for a pet on the same date
            $table->unique(['pet_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_histories');
    }
};
