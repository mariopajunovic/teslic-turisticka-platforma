<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE `news` DROP INDEX `news_slug_unique`');
        DB::statement('ALTER TABLE `news` MODIFY `slug` TEXT NULL');

        DB::table('news')->select('id', 'slug')->orderBy('id')->chunk(300, function ($rows) {
            foreach ($rows as $r) {
                DB::table('news')->where('id', $r->id)->update([
                    'slug' => json_encode(['sr' => (string) $r->slug], JSON_UNESCAPED_UNICODE),
                ]);
            }
        });

        DB::statement('ALTER TABLE `news` MODIFY `slug` JSON NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE `news` MODIFY `slug` TEXT NULL');
        DB::statement("UPDATE `news` SET `slug` = JSON_UNQUOTE(JSON_EXTRACT(`slug`, '$.sr'))");
        DB::statement('ALTER TABLE `news` MODIFY `slug` VARCHAR(255) NULL');

        Schema::table('news', function ($table) {
            $table->unique('slug', 'news_slug_unique');
        });
    }
};
