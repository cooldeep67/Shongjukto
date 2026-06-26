<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('sponsorships', 'beneficiary_id')) {
            Schema::table('sponsorships', function (Blueprint $table) {
                $table->dropForeign(['beneficiary_id']);
                $table->dropColumn('beneficiary_id');
            });
        }

        if (! Schema::hasColumn('sponsorships', 'student_id')) {
            Schema::table('sponsorships', function (Blueprint $table) {
                $table->unsignedBigInteger('student_id')->after('donor_id');
            });
        }

        Schema::table('sponsorships', function (Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('sponsorships', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropColumn('student_id');
            $table->foreignId('beneficiary_id')->constrained('users')->onDelete('cascade');
        });
    }
};
