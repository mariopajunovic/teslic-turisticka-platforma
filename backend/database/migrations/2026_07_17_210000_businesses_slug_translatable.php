<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('businesses', function ($table) {
            $table->dropUnique(['slug']);
        });

        DB::table('businesses')->orderBy('id')->get()->each(function ($row) {
            $vrijednost = is_string($row->slug) && str_starts_with(trim($row->slug), '{')
                ? $row->slug
                : json_encode(['sr' => $row->slug]);

            DB::table('businesses')->where('id', $row->id)->update(['slug' => $vrijednost]);
        });

        DB::statement('ALTER TABLE businesses MODIFY slug JSON NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE businesses MODIFY slug VARCHAR(255) NULL');

        DB::table('businesses')->orderBy('id')->get()->each(function ($row) {
            $map = json_decode($row->slug ?? '{}', true) ?: [];
            DB::table('businesses')->where('id', $row->id)->update(['slug' => $map['sr'] ?? null]);
        });

        Schema::table('businesses', function ($table) {
            $table->unique('slug');
        });
    }
};
