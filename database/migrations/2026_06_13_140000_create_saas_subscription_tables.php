<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // active | grace | frozen — only meaningful on admin accounts.
            $table->string('subscription_status', 16)->default('active')->index();
            $table->string('billing_period', 16)->nullable(); // monthly | annual
            $table->timestamp('subscription_started_at')->nullable();
            $table->timestamp('subscription_due_at')->nullable()->index();
            $table->timestamp('frozen_at')->nullable();
        });

        // Bills/receipts issued to admins for their SaaS subscription.
        Schema::create('saas_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('amount_tnd', 10, 3);
            $table->string('period', 16); // monthly | annual
            $table->date('period_start');
            $table->date('period_end');
            // pending | paid | overdue
            $table->string('status', 16)->default('pending')->index();
            $table->timestamp('paid_at')->nullable();
            $table->string('receipt_pdf_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saas_payments');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'subscription_status',
                'billing_period',
                'subscription_started_at',
                'subscription_due_at',
                'frozen_at',
            ]);
        });
    }
};
