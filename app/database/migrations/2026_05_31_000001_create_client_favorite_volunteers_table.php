<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_favorite_volunteers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('volunteer_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['client_id', 'volunteer_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_favorite_volunteers');
    }
};
