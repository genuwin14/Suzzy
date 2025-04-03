<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('lab_keys', function (Blueprint $table) {
            $table->string('key_id', 45)->primary();
            $table->string('laboratory', 45)->nullable();
            $table->enum('status', ['Available', 'Borrowed'])->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lab_keys');
    }
};
