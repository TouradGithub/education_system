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
        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('password');

            //Fatherinformation
            $table->string('father_first_name');
            $table->string('father_last_name');
            $table->string('father_mobile');
            $table->string('father_dob');
            $table->string('school_id');
            $table->string('father_occupation');
            $table->string('image');
            $table->string('token')->nullable();
            $table->string('cratedby');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parents');
    }
};
