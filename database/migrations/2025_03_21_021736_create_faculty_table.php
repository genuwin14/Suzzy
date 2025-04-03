<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('faculty', function (Blueprint $table) {
            $table->string('faculty_id', 100)->primary();
            $table->string('rfid_uid', 255)->unique()->nullable();
            $table->string('fname', 45)->nullable();
            $table->string('mname', 45)->nullable();
            $table->string('lname', 45)->nullable();
            $table->string('suffix', 45)->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->enum('status', ['Enabled', 'Disabled'])->nullable();
           
            $table->foreign('admin_id')->references('admin_id')->on('admins')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('faculty');
    }
};
