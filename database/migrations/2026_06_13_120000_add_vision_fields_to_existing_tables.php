<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Six-digit memorable passcode for parents (issued by admin, no self-set password)
            $table->string('passcode', 6)->nullable()->index();
            // Marks the synthetic "SmartKids System" account used for system-issued DMs
            $table->boolean('is_system')->default(false)->index();
            // For admins: monthly tuition price in TND (changed from profile; broadcast on update)
            $table->decimal('monthly_tuition_tnd', 8, 3)->nullable();
            // For SaaS multi-tenancy (filled in Task 5): admin user id this row belongs to
            $table->foreignId('tenant_admin_id')->nullable()->constrained('users')->nullOnDelete();
        });

        Schema::table('activities', function (Blueprint $table) {
            // pending_approval | approved | rejected | completed
            $table->string('status', 32)->default('approved')->index();
            // Educator who requested the activity (null for legacy / admin-created)
            $table->foreignId('requested_by')->nullable()->after('educator_id')->constrained('users')->nullOnDelete();
            // Admin who approved/rejected
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->string('rejection_reason', 500)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropForeign(['requested_by']);
            $table->dropColumn(['status', 'requested_by', 'approved_by', 'approved_at', 'rejection_reason']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['tenant_admin_id']);
            $table->dropColumn(['passcode', 'is_system', 'monthly_tuition_tnd', 'tenant_admin_id']);
        });
    }
};
