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
        Schema::create('idcard_settings', function (Blueprint $table) {
            $table->id();
            $table->string('school_id');
            $table->string('country_text');
            $table->string('country_image')->nullable();
            $table->string('background_image')->nullable();
            $table->string('header_color')->nullable();
            $table->string('header_text_color')->nullable();
            $table->string('signature')->nullable();
            $table->string('layout_type')->nullable();
            $table->string('profile_image_style');
            $table->string('card_width');
            $table->string('card_height');
            $table->string('student_id_card_fields');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('idcard_settings');
    }
};
