<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('question_type');
            $table->longText('question')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
;