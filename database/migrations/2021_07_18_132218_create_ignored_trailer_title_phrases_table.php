<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIgnoredTrailerTitlePhrasesTable extends Migration
{
    public function up()
    {
        Schema::create('ignored_trailer_title_phrases', function (Blueprint $table) {
            // ID
            $table->id();

            // Relationships
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            // Data
            $table->string('phrase', 25);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ignored_trailer_title_phrases');
    }
}
