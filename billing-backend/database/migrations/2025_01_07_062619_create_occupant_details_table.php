<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('occupant_details', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id')->unique();
            $table->unsignedBigInteger('h_id');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->unsignedBigInteger('phone_code_id')->nullable();            
            $table->string('mobile');
            $table->string('email')->unique();
            $table->date('occupation_date');
            $table->timestamps();
            // Foreign key constraint
            $table->foreign('phone_code_id')->references('id')->on('phone_codes')->onDelete('cascade');
            $table->foreign('h_id')->references('id')->on('house_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('occupant_details');
    }
};
