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
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            $table->string('first_name');
            $table->string('last_name');

            $table->integer('grade_id');
            $table->integer('class_id');
            $table->integer('section_id');

            $table->integer('acadimic_id');
            $table->integer('school_id');

            $table->string('gender');
            $table->string('image')->nullable();
            $table->string('academic_year');
            $table->string('date_birth');
            $table->integer('roll_number');
            $table->string('blood_group', 32)->nullable();
            $table->integer('parent_id');
            $table->string('current_address');
            $table->string('permanent_address');
            $table->string('qr_code');
            $table->string('cratedby');
            $table->string('status');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
