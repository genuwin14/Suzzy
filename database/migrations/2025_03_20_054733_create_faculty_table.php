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
        Schema::create('faculty', function (Blueprint $table) {
            $table->string('faculty_id', 100)->primary();
            $table->string('rfid_uid', 255)->unique()->nullable();
            $table->string('fname', 45)->nullable();
            $table->string('mname', 45)->nullable();
            $table->string('lname', 45)->nullable();
            $table->string('suffix', 45)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faculty');
    }
};
