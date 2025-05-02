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
        Schema::table('occupant_details', function (Blueprint $table) {
            $table->string('first_name')->nullable()->change();
            $table->string('mobile')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->date('occupation_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('occupant_details', function (Blueprint $table) {
            $table->string('first_name')->nullable(false)->change();
            $table->string('mobile')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
            $table->date('occupation_date')->nullable(false)->change();
        });
    }
};
