<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('naslov');
            $table->string('slug')->unique();
            $table->text('izvod')->nullable();
            $table->longText('sadrzaj')->nullable();
            $table->string('autor')->nullable();
            $table->text('autor_bio')->nullable();
            $table->date('datum')->nullable();
            $table->boolean('featured')->default(false);
            $table->string('status')->default('nacrt')->index();
            $table->text('rejection_reason')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};
