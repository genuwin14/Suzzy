<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id('log_id');

            $table->string('key_id', 45)->nullable();
            $table->string('details', 45)->nullable();
            
            $table->string('faculty_id_borrowed', 100)->nullable();
            $table->timestamp('date_time_borrowed')->nullable();

            $table->string('faculty_id_returned', 100)->nullable();
            $table->timestamp('date_time_returned')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('faculty_id_borrowed')->references('faculty_id')->on('faculty')->onDelete('cascade');
            $table->foreign('faculty_id_returned')->references('faculty_id')->on('faculty')->onDelete('cascade');
            $table->foreign('key_id')->references('key_id')->on('lab_keys')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('logs');
    }
};
