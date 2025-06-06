<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('billing_details', function (Blueprint $table) {
            $table->decimal('last_meter_reading', 10, 2)->nullable()->after('last_pay_date');
            $table->decimal('curr_meter_reading', 10, 2)->nullable()->after('last_meter_reading');
        });
    }

    public function down(): void
    {
        Schema::table('billings', function (Blueprint $table) {
            $table->dropColumn(['last_meter_reading', 'curr_meter_reading']);
        });
    }
};
