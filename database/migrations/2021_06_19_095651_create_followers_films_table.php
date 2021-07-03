<?php

use App\Models\Film;
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
            $table->enum('status', [Film::TO_SHORTLIST, Film::SHORTLISTED, Film::WATCHED])->default('to_shortlist');

            $table->timestamps();

            // Constraints
            $table->unique(['user_id', 'film_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('followers_films');
    }
}
