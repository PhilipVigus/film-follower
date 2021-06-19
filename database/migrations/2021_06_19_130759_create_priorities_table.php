<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrioritiesTable extends Migration
{
    public function up()
    {
        Schema::create('priorities', function (Blueprint $table) {
            // ID
            $table->id();

            // Relationships
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('film_id')->constrained('films')->cascadeOnDelete();

            // Data
            $table->enum('level', [1, 2, 3]);
            $table->text('note');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('priorities');
    }
}
