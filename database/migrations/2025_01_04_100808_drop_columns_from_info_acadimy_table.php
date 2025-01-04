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
        Schema::table('info_acadimy', function (Blueprint $table) {
            $table->dropColumn(['adress', 'image', 'email']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('info_acadimy', function (Blueprint $table) {
            $table->string('adress');
            $table->string('image')->nullable();
            $table->string('email')->unique();
        });
    }
};
