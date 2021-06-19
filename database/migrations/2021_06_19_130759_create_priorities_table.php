<?php

use App\Models\Priority;
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
            $table->enum('level', [Priority::LOW, Priority::MEDIUM, Priority::HIGH]);
            $table->text('note')->nullable();

            $table->timestamps();

            // Constraints
            $table->unique(['user_id', 'film_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('priorities');
    }
}
