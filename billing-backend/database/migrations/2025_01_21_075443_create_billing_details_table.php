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
            $table->date('last_pay_date')->nullable();
            $table->date('reading_date');
            $table->decimal('last_meter_reading', 10, 2)->nullable();
            $table->decimal('last_reading', 10, 2)->nullable();
            $table->decimal('current_meter_reading', 10, 2);
            $table->decimal('current_reading', 10, 2)->nullable();
            $table->decimal('current_units', 10, 2)->nullable();
            $table->decimal('last_units', 10, 2)->nullable();
            $table->integer('remission')->nullable();
            $table->string('pdf_path')->nullable();
            $table->integer('unit_after_remission')->nullable();
            $table->decimal('rate_per_unit', 10, 2);
            $table->decimal('current_charges', 10, 2);
            $table->decimal('outstanding_dues', 10, 2)->default(0);
            $table->date('pay_date')->nullable();
            $table->enum('status', ['New', 'Generated', 'Approved'])->default('New');
            $table->tinyInteger('payment_status')->default(0); 
            $table->timestamps();

            $table->index(['house_id', 'occupant_id']);
            $table->index('reading_date');
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('billing_details');
    }
};
