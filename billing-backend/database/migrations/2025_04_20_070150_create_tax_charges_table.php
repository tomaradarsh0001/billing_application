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
        Schema::create('tax_charges', function (Blueprint $table) {
            $table->id();
            $table->string('tax_name');
            $table->decimal('tax_percentage', 5, 2);
            $table->date('from_date');
            $table->date('till_date')->nullable();
            $table->boolean('status')->default(true); // true for active
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tax_charges');
    }
};
