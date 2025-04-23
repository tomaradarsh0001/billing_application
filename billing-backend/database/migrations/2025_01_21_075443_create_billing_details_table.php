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
        Schema::create('billing_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('house_id')->constrained('house_details')->onDelete('cascade');
            $table->foreignId('occupant_id')->constrained('occupant_details')->onDelete('cascade');
            $table->date('last_pay_date');
            $table->decimal('outstanding_dues', 10, 2);
            $table->decimal('last_reading', 10, 2);
            $table->decimal('current_reading', 10, 2);
            $table->decimal('current_charges', 10, 2);
            $table->date('pay_date');
            $table->enum('status', ['New', 'Generated', 'Approved'])->default('New');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billing_details');
    }
};
