<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->json('naslov')->nullable();
            $table->json('slug')->nullable();
            $table->json('opis')->nullable();
            $table->json('opis_dug')->nullable();
            $table->json('lokacija')->nullable();
            $table->text('radno_vrijeme')->nullable();
            $table->boolean('preporuceno')->default(false);
            $table->json('kontakt')->nullable();
            $table->json('drustvene')->nullable();
            $table->json('usluge')->nullable();
            $table->string('cijena_raspon', 8)->nullable();
            $table->unsignedSmallInteger('godina_osnivanja')->nullable();
            $table->string('jib', 13)->nullable();
            $table->json('nacin_placanja')->nullable();
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            $table->string('status')->default('nacrt')->index();
            $table->text('rejection_reason')->nullable();
            $table->json('pending')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
