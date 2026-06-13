<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates the activities table for planning kindergarten events.
     */
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id(); // Identifiant unique de l'activité
            $table->string('name'); // Nom de l'activité
            $table->text('description')->nullable(); // Description affichée aux parents
            $table->date('scheduled_date'); // Date prévue de l'activité
            $table->time('scheduled_time'); // Heure de début
            $table->foreignId('educator_id')->constrained('teachers'); // Éducateur responsable de l'activité
            $table->unsignedInteger('max_participants')->default(30); // Nombre max de participants
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
