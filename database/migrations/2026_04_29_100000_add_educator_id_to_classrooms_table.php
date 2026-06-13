<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds educator assignment foreign key to classrooms table.
     */
    public function up(): void
    {
        Schema::table('classrooms', function (Blueprint $table) {
            $table->foreignId('educator_id')->nullable()->after('capacite')->constrained('teachers')->nullOnDelete(); // ID de l'enseignant assigné à cette classe
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classrooms', function (Blueprint $table) {
            $table->dropForeign(['educator_id']);
            $table->dropColumn('educator_id');
        });
    }
};
