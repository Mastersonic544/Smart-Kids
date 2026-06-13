<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates the classrooms table for kindergarten class/group management.
     */
    public function up(): void
    {
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id(); // Identifiant unique de la classe
            $table->string('nom'); // Nom de la classe (ex: "Petite Section A")
            $table->string('niveau'); // Niveau d'âge (ex: "petite_section", "moyenne_section", "grande_section")
            $table->integer('capacite')->default(25); // Nombre maximum d'enfants dans la classe
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};
