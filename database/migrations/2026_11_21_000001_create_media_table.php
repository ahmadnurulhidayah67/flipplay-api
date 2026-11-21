<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('type', 20)->default('Anime');   // Anime, Film, Series
            $table->string('genre')->nullable();
            $table->decimal('score', 3, 1)->default(0);
            $table->unsignedInteger('episodes')->nullable();
            $table->string('vibe')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
