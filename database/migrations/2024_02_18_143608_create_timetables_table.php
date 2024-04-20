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
        Schema::create('timetables', function (Blueprint $table) {
            $table->id();
            $table->integer('subject_teacher_id');
            $table->integer('school_id');
            $table->integer('session_year');
            $table->integer('section_id');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('note', 1024)->nullable();
            $table->integer('day')->comment('1=monday,2=tuesday,3=wednesday,4=thursday,5=friday,6=saturday,7=sunday');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timetables');
    }
};
