<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates the children table for managing enrolled kindergarten children.
     */
    public function up(): void
    {
        Schema::create('children', function (Blueprint $table) {
            $table->id(); // Identifiant unique de l'enfant
            $table->string('nom'); // Nom de famille de l'enfant
            $table->string('prenom'); // Prénom de l'enfant
            $table->date('date_naissance'); // Date de naissance de l'enfant
            $table->text('allergies')->nullable(); // Allergies connues (texte libre, nullable)
            $table->foreignId('parent_id')->constrained('users'); // Lien vers le compte parent (table users)
            $table->foreignId('classroom_id')->nullable()->constrained(); // Classe assignée (nullable si pas encore affecté)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('children');
    }
};
