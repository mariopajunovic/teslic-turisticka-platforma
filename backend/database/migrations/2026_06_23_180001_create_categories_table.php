<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->json('slug')->nullable();
            $table->json('label')->nullable();
            $table->json('opis')->nullable();
            $table->string('hero_image')->nullable();
            $table->json('meta_title')->nullable();
            $table->json('meta_description')->nullable();
            $table->string('icon')->nullable();
            $table->string('color', 9)->nullable();
            $table->string('type')->nullable();
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('visible')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
