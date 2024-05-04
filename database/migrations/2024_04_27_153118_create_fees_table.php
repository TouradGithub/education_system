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
        Schema::create('feesClasses', function (Blueprint $table) {
            $table->id();
            $table->integer('class_section_id');
            $table->float('amount');
            $table->string('school_id');
            $table->integer('session_year_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feesClasses');
    }
};
