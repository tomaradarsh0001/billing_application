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
        Schema::table('house_details', function (Blueprint $table) {
            $table->string('meter_number')->nullable()->after('house_type');
            $table->string('ews_qtr')->nullable()->after('meter_number');
        });
    }

    public function down()
    {
        Schema::table('house_details', function (Blueprint $table) {
            $table->dropColumn('meter_number');
        });
    }
};
