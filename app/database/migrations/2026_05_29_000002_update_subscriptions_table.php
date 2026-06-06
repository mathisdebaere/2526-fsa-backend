<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->decimal('amount', 6, 2)->default(5.00)->after('end_date');
            $table->timestamp('paid_at')->nullable()->after('amount');
        });

        DB::statement("ALTER TABLE subscriptions MODIFY COLUMN status ENUM('pending','active','cancelled','expired') DEFAULT 'pending'");
    }

    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropColumn(['amount', 'paid_at']);
        });

        DB::statement("ALTER TABLE subscriptions MODIFY COLUMN status ENUM('active','cancelled','expired') DEFAULT 'active'");
    }
};
