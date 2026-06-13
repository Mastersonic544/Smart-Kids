<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates the enrollments table for tracking child enrollment status and waitlists.
     */
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id(); // Identifiant unique de l'inscription
            $table->foreignId('child_id')->constrained()->onDelete('cascade'); // Lien vers l'enfant inscrit
            $table->enum('statut', ['en attente', 'validée', 'liste_d_attente'])->default('en attente'); // Statut de la demande d'inscription
            $table->date('date_inscription'); // Date de soumission de la demande
            $table->string('pieces_justificatives')->nullable(); // Chemin vers les pièces justificatives uploadées
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
