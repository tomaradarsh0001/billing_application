<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPdfPathToBillingDetails extends Migration
{
    public function up()
    {
        Schema::table('billing_details', function (Blueprint $table) {
            $table->string('pdf_path')->nullable()->after('unit_after_remission');
        });
    }

    public function down()
    {
        Schema::table('billing_details', function (Blueprint $table) {
            $table->dropColumn('pdf_path');
        });
    }
}
