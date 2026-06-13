<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates the messages table for internal messaging.
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id(); // Identifiant unique du message
            $table->foreignId('sender_id')->constrained('users'); // Expéditeur du message
            $table->foreignId('receiver_id')->constrained('users'); // Destinataire du message
            $table->text('body'); // Contenu du message
            $table->timestamp('read_at')->nullable(); // Date et heure de lecture du message (null = non lu)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
