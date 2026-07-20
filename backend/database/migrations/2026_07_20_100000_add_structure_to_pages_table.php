<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()->after('id')->constrained('pages')->nullOnDelete();
            $table->string('resource_type')->nullable()->after('is_system');
            $table->foreignId('category_id')->nullable()->after('resource_type')->constrained('categories')->nullOnDelete();
        });

        foreach (DB::table('pages')->select('id', 'slug')->get() as $page) {
            if ($page->slug === null || str_starts_with((string) $page->slug, '{')) {
                continue;
            }

            DB::table('pages')->where('id', $page->id)->update([
                'slug' => json_encode(['sr' => $page->slug], JSON_UNESCAPED_UNICODE),
            ]);
        }

        $indeksi = collect(DB::select('SHOW INDEX FROM pages'))->pluck('Key_name')->unique();

        if ($indeksi->contains('pages_slug_unique')) {
            Schema::table('pages', function (Blueprint $table) {
                $table->dropUnique('pages_slug_unique');
            });
        }

        DB::statement('ALTER TABLE pages MODIFY slug JSON NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE pages MODIFY slug VARCHAR(255) NULL');

        foreach (DB::table('pages')->select('id', 'slug')->get() as $page) {
            $dekodiran = json_decode((string) $page->slug, true);

            if (is_array($dekodiran)) {
                DB::table('pages')->where('id', $page->id)->update([
                    'slug' => $dekodiran['sr'] ?? reset($dekodiran) ?: null,
                ]);
            }
        }

        Schema::table('pages', function (Blueprint $table) {
            $table->dropConstrainedForeignId('parent_id');
            $table->dropConstrainedForeignId('category_id');
            $table->dropColumn('resource_type');
        });
    }
};
