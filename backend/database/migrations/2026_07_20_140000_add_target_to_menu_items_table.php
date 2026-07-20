<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->string('target_type')->nullable()->after('label');
            $table->unsignedBigInteger('target_id')->nullable()->after('target_type');
            $table->index(['target_type', 'target_id']);
            $table->string('url')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropIndex(['target_type', 'target_id']);
            $table->dropColumn(['target_type', 'target_id']);
        });
    }
};
