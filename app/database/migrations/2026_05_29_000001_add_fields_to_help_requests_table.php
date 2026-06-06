<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('help_requests', function (Blueprint $table) {
            $table->string('region', 100)->nullable()->after('extra_notes');
            $table->date('date')->nullable()->after('region');
            $table->time('time')->nullable()->after('date');
            $table->foreignId('volunteer_id')->nullable()->constrained()->nullOnDelete()->after('client_id');
        });
    }

    public function down(): void
    {
        Schema::table('help_requests', function (Blueprint $table) {
            $table->dropForeign(['volunteer_id']);
            $table->dropColumn(['region', 'date', 'time', 'volunteer_id']);
        });
    }
};
