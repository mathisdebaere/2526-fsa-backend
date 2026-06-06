<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('volunteer_help_request_category', function (Blueprint $table) {
            $table->foreignId('volunteer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('help_request_category_id')->constrained()->cascadeOnDelete();
            $table->primary(['volunteer_id', 'help_request_category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('volunteer_help_request_category');
    }
};
