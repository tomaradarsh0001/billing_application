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
        Schema::table('billing_details', function (Blueprint $table) {
            $table->integer('remission')->after('pay_date')->nullable();
            $table->integer('unit_after_remission')->after('remission')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('billing_details', function (Blueprint $table) {
            $table->dropColumn('remission');
            $table->integer('unit_after_remission');
        });
    }
};
