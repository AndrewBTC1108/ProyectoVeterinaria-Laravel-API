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
        // Agrega las nuevas columnas
        Schema::table('users', function (Blueprint $table) {
            $table->string('cedula', 20)->unique()->after('id');
            $table->string('last_name')->after('name');
            $table->string('phone_number', 15)->after('email');
            $table->boolean('admin')->default(0); //1 si es admin, 0 si no es
            $table->boolean('doctor')->default(0); //1 si es admin, 0 si no es
        });
    }

    public function down(): void
    {
        // Elimina las nuevas columnas
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['cedula', 'last_name', 'phone_number', 'admin', 'doctor']);
        });
    }
};

