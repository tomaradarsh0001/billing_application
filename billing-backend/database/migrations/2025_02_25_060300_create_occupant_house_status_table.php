<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOccupantHouseStatusTable extends Migration
{
    public function up()
    {
        Schema::create('occupant_house_status', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('occupant_id');
            $table->unsignedBigInteger('house_id');
            $table->enum('status', ['active', 'inactive', 'moved_out'])->default('active');
            $table->date('added_date');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('occupant_id')->references('id')->on('occupant_details')->onDelete('cascade');
            $table->foreign('house_id')->references('id')->on('house_details')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('occupant_house_status');
    }
}
