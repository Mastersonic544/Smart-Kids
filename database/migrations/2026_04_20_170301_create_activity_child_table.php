<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates the pivot table for activities and children.
     */
    public function up(): void
    {
        Schema::create('activity_child', function (Blueprint $table) {
            $table->foreignId('activity_id')->constrained('activities')->onDelete('cascade'); // Lien vers l'activité
            $table->foreignId('child_id')->constrained('children')->onDelete('cascade'); // Lien vers l'enfant
            $table->boolean('attended')->default(false); // L'enfant a-t-il participé à l'activité ?
            $table->primary(['activity_id', 'child_id']); // Clé primaire composite
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_child');
    }
};
