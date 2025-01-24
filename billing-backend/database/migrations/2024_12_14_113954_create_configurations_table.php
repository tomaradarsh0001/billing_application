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
        Schema::create('configurations', function (Blueprint $table) {
            $table->id();
            $table->string('app_name')->nullable();
            $table->string('app_logo')->nullable(); 
            $table->string('app_tagline')->nullable();
            $table->string('app_font_primary')->nullable();
            $table->string('app_font_secondary')->nullable();
            $table->string('app_theme_primary_light')->nullable();
            $table->string('app_theme_primary_dark')->nullable();
            $table->string('app_theme_secondary_light')->nullable();
            $table->string('app_theme_secondary_dark')->nullable();
            $table->string('app_theme_background')->nullable();
            $table->string('app_theme_text_primary')->nullable();
            $table->string('app_theme_text_secondary')->nullable();            
            $table->string('app_theme_svg_login')->nullable();            
            $table->string('app_theme_svg_signup')->nullable();            
            $table->string('app_theme_links')->nullable();            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configurations');
    }
};
