<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('naslov');
            $table->string('slug')->unique();
            $table->text('opis')->nullable();
            $table->longText('opis_dug')->nullable();
            $table->string('lokacija')->nullable();
            $table->boolean('preporuceno')->default(false);
            $table->text('kako_doci')->nullable();
            $table->text('savjeti')->nullable();
            $table->string('sezona')->nullable();
            $table->string('radno_vrijeme')->nullable();
            $table->string('ulaznice')->nullable();
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            $table->string('status')->default('nacrt')->index();
            $table->text('rejection_reason')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
