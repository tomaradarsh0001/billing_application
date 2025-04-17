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
        Schema::create('per_unit_rates', function (Blueprint $table) {
            $table->id();
            $table->decimal('unit_rate', 8, 2); // Price in Rs
            $table->date('from_date');
            $table->date('till_date')->nullable();
            $table->boolean('status')->default(true); // true = active, false = inactive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('per_unit_rates');
    }
};
