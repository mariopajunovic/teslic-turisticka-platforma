<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->text('opis')->nullable()->after('label');
            $table->string('hero_image')->nullable()->after('opis');
            $table->string('meta_title')->nullable()->after('hero_image');
            $table->text('meta_description')->nullable()->after('meta_title');
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['opis', 'hero_image', 'meta_title', 'meta_description']);
        });
    }
};
