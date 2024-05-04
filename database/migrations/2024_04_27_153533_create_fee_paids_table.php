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
            $table->id();
            $table->integer('fees_class_id');
            $table->integer('student_id');
            $table->tinyInteger('mode')->comment('0 - cash 1 - cheque 2 - online');
            $table->string('payment_transaction_id')->nullable(true);
            $table->tinyInteger('is_fully_paid')->comment('0 - no 1 - yes')->default(1);
            $table->string('month');
            $table->integer('amount');
            $table->date('date');
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
