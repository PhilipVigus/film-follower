<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIgnoredTagsTable extends Migration
{
    public function up()
    {
        Schema::create('ignored_tags', function (Blueprint $table) {
            // ID
            $table->id();

            // Relationships
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained('tags')->cascadeOnDelete();

            // Data
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ignored_tags');
    }
}
