<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates the teachers table for educator profile management.
     */
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id(); // Identifiant unique de l'enseignant
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Lien vers l'utilisateur (rôle éducateur)
            $table->string('nom'); // Nom de famille de l'enseignant
            $table->string('prenom'); // Prénom de l'enseignant
            $table->string('email')->unique(); // Adresse email unique
            $table->string('telephone')->nullable(); // Numéro de téléphone (optionnel)
            $table->string('document_contractuel')->nullable(); // Chemin vers le document contractuel (PDF)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
