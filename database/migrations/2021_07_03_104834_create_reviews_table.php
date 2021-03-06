<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            // ID
            $table->id();

            // Relationships
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('film_id')->constrained('films')->cascadeOnDelete();

            // Data
            $table->integer('rating');
            $table->text('comment')->nullable();

            $table->timestamps();

            // Constraints
            $table->unique(['user_id', 'film_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
