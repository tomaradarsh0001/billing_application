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
            if (Schema::hasColumn('house_details', 'landmark')) {
                $table->dropColumn('landmark');
            }

            // Add the 'house_type' column after 'hno'
            $table->string('house_type')->after('hno')->nullable();
        });
    }

    public function down()
    {
        Schema::table('house_details', function (Blueprint $table) {
            $table->renameColumn('house_type', 'landmark');
        });
    }
};
