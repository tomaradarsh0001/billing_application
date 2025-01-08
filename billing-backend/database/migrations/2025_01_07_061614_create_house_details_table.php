<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('house_details', function (Blueprint $table) {
            $table->id();
            $table->string('hno');
            $table->string('area');
            $table->string('landmark')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('pincode');
            $table->timestamps();
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('house_details');
    }
};
