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
        Schema::create('monthly_sales', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('medication_id')->constrained()->onDelete('cascade');
            $table->double('profit');
            $table->integer('amount');
            $table->double('total');
            $table->double('gain_value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_sales');
    }
};
