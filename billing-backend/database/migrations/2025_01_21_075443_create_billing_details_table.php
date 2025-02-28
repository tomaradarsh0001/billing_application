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
            $table->foreignId('occ_id')->constrained('occupant_house_status')->onDelete('cascade');
            $table->unsignedBigInteger('house_id'); // Foreign key
            $table->unsignedBigInteger('occupant_id'); // Foreign key
            $table->decimal('last_reading', 10, 2);
            $table->date('last_pay_date');
            $table->decimal('outstanding_dues', 10, 2);
            $table->decimal('current_reading', 10, 2);
            $table->decimal('current_charges', 10, 2);
            $table->date('pay_date');
            $table->enum('status', ['paid', 'unpaid'])->default('unpaid');
            $table->timestamps();

            $table->foreign('house_id')->references('id')->on('house_details')->onDelete('cascade');
            $table->foreign('occupant_id')->references('id')->on('occupant_details')->onDelete('cascade');
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
