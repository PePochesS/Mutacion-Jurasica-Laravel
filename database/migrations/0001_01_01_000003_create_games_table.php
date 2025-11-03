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
        Schema::create('games', function (Blueprint $table) {
            $table->id();

            // Usuario que creó la partida
            $table->foreignId('owner_id')->nullable()->constrained('users')->nullOnDelete();

            // Nombre opcional
            $table->string('name')->nullable();

            // Cantidad de jugadores
            $table->unsignedTinyInteger('player_count')->default(1);

            // Estado de la partida
            $table->enum('status', ['active', 'finished'])->default('active');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
