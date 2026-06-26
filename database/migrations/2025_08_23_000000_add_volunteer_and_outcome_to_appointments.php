<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->foreignId('volunteer_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('outcome', ['attended', 'missed', 'cancelled', 'pending'])->default('pending');
            $table->text('notes')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['volunteer_id']);
            $table->dropColumn(['volunteer_id', 'outcome', 'notes']);
        });
    }
};
