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
        Schema::create('fee_paids', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('fees_id');
            $table->integer('student_id');
            $table->tinyInteger('status')->default(0)->comment('0=Not Paid,1=Paid');
            $table->string('description', 1024)->nullable();
            $table->string('school_id');
            $table->integer('session_year_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_paids');
    }
};
