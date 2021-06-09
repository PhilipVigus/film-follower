<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilmsTable extends Migration
{
    public function up()
    {
        Schema::create('films', function (Blueprint $table) {
            // ID
            $table->id();

            // Data
            $table->string('guid')->unique();
            $table->string('title');
            $table->string('slug')->unique();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('films');
    }
}
