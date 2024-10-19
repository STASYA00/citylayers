<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('config_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('config_id');
            $table->unsignedBigInteger('category_id');
            $table->text("color");
            $table->text("high");
            $table->text("low");
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('config_categories');
    }
}
;