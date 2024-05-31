<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('subcategories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('category');
            $table->unsignedBigInteger('subcategory');
        });
    }

    public function down()
    {
        Schema::dropIfExists('subcategories');
    }
}
;