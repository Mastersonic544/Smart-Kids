<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // YYYY-MM month label used as the dunning bucket (one payment per child per month)
            $table->string('mois', 7)->nullable()->index();
            // Due date — set when the bill is issued, drives the "overdue" filter
            $table->date('date_echeance')->nullable();
            // When the parent settled the bill (null while pending/overdue)
            $table->timestamp('paye_le')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['mois', 'date_echeance', 'paye_le']);
        });
    }
};
