<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 45);
            $table->string('last_name', 45);
            $table->date('date_of_birth')->nullable();
            $table->string('email', 255)->nullable()->unique();
            $table->string('password', 255);
            $table->string('phone', 45)->nullable();
            $table->string('profile_photo_url', 255)->nullable();
            $table->enum('role', ['volunteer', 'client', 'advisor']);
            $table->boolean('privacy_agreement')->default(false);
            $table->dateTime('privacy_agreement_timestamp')->nullable();
            $table->enum('account_status', ['waiting_for_interview', 'verified'])->default('waiting_for_interview');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
