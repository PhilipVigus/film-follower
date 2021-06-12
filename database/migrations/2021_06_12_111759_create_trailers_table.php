<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrailersTable extends Migration
{
    public function up()
    {
        Schema::create('trailers', function (Blueprint $table) {
            // ID
            $table->id();

            // Relationships
            $table->foreignId('film_id')->constrained('films')->cascadeOnDelete();

            // Data
            $table->string('guid')->unique();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('type');
            $table->string('image');
            $table->string('link');
            $table->dateTime('uploaded_at');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('trailers');
    }
}
