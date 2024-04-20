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
        Schema::create('teachers', function (Blueprint $table) {
                $table->id();
                $table->string('first_name', 512);
                $table->string('last_name', 512);
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->string('current_address');
                $table->string('permanent_address');
                $table->string('gender');
                $table->string('mobile')->nullable();
                $table->string('image', 512)->nullable();
                $table->date('dob')->nullable();
                $table->string('qualification', 512);
                $table->integer('school_id');
                $table->tinyInteger('status')->default(1);
                $table->timestamps();
                $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
