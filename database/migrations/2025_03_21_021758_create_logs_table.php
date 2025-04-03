<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id('log_id');
            $table->string('faculty_id', 100)->nullable();
            $table->string('key_id', 45)->nullable();
            $table->string('details', 45)->nullable();
            $table->timestamp('date_time_borrowed')->nullable();
            $table->timestamp('date_time_returned')->nullable();
            $table->timestamps();
           
            $table->foreign('faculty_id')->references('faculty_id')->on('faculty')->onDelete('cascade');
            $table->foreign('key_id')->references('key_id')->on('lab_keys')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('logs');
    }
};