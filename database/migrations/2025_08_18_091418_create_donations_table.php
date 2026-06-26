<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::create('donations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('donor_id')->constrained('users')->onDelete('cascade');
        $table->string('item'); // e.g., food, clothes, medicine
        $table->integer('quantity')->nullable();
        $table->date('scheduled_date');
        $table->time('scheduled_time');
        $table->enum('status', ['pending', 'accepted', 'collected'])->default('pending');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
