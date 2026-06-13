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
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); // Identifiant unique du paiement
            $table->foreignId('child_id')->constrained(); // Référence à l'enfant concerné
            $table->decimal('montant', 8, 2); // Montant du paiement en DT
            $table->string('statut'); // État du paiement ('payé', 'en attente')
            $table->string('pdf_path')->nullable(); // Chemin vers le reçu PDF généré
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
