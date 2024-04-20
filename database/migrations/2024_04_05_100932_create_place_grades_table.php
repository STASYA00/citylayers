<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlaceGradesTable extends Migration
{
    public function up()
    {
        Schema::create('place_grades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('place_detail_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('category_id');
            $table->integer('grade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('place_grades');
    }
}
