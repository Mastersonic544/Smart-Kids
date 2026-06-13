<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates the meals table for weekly menus.
     */
    public function up(): void
    {
        Schema::create('meals', function (Blueprint $table) {
            $table->id(); // Identifiant unique du menu
            $table->date('week_start'); // Date du lundi de la semaine du menu
            $table->json('monday')->nullable(); // Menu du lundi sous forme JSON
            $table->json('tuesday')->nullable(); // Menu du mardi sous forme JSON
            $table->json('wednesday')->nullable(); // Menu du mercredi sous forme JSON
            $table->json('thursday')->nullable(); // Menu du jeudi sous forme JSON
            $table->json('friday')->nullable(); // Menu du vendredi sous forme JSON
            $table->foreignId('created_by')->constrained('users'); // Utilisateur ayant créé le menu
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meals');
    }
};
