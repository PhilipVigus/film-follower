<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFollowersFilmsTable extends Migration
{
    public function up()
    {
        Schema::create('followers_films', function (Blueprint $table) {
            // ID
            $table->id();

            // Relationships
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('film_id')->constrained('films')->cascadeOnDelete();

            // Data
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('followers_films');
    }
}
