<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToHelpRequestsTable extends Migration
{
    public function up()
    {
        Schema::table('help_requests', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('description');
        });
    }

    public function down()
    {
        Schema::table('help_requests', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
