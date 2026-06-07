<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'first_name')) {
                $table->string('first_name', 45)->after('id');
            }
            if (! Schema::hasColumn('users', 'last_name')) {
                $table->string('last_name', 45)->after('first_name');
            }
            if (! Schema::hasColumn('users', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable()->after('last_name');
            }
            if (! Schema::hasColumn('users', 'phone')) {
                $table->string('phone', 45)->nullable()->after('password');
            }
            if (! Schema::hasColumn('users', 'profile_photo_url')) {
                $table->string('profile_photo_url', 255)->nullable()->after('phone');
            }
            if (! Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['volunteer', 'client', 'advisor'])->after('profile_photo_url');
            }
            if (! Schema::hasColumn('users', 'privacy_agreement')) {
                $table->boolean('privacy_agreement')->default(false)->after('role');
            }
            if (! Schema::hasColumn('users', 'privacy_agreement_timestamp')) {
                $table->dateTime('privacy_agreement_timestamp')->nullable()->after('privacy_agreement');
            }
            if (! Schema::hasColumn('users', 'account_status')) {
                $table->enum('account_status', ['waiting_for_interview', 'verified'])->default('waiting_for_interview')->after('privacy_agreement_timestamp');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'first_name', 'last_name', 'date_of_birth',
                'phone', 'profile_photo_url', 'role',
                'privacy_agreement', 'privacy_agreement_timestamp', 'account_status',
            ]);
        });
    }
};
