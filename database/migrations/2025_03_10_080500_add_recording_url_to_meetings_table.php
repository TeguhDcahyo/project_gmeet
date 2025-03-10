<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('meetings', function (Blueprint $table) {
        $table->string('recording_url')->nullable()->after('participants');
    });
}

public function down()
{
    Schema::table('meetings', function (Blueprint $table) {
        $table->dropColumn('recording_url');
    });
}
};
