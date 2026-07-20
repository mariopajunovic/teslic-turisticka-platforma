<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected array $tabele = ['locations', 'events', 'ads', 'stories'];

    public function up(): void
    {
        foreach ($this->tabele as $t) {
            DB::statement("ALTER TABLE `{$t}` DROP INDEX `{$t}_slug_unique`");
            DB::statement("ALTER TABLE `{$t}` MODIFY `slug` TEXT NULL");

            DB::table($t)->select('id', 'slug')->orderBy('id')->chunk(300, function ($rows) use ($t) {
                foreach ($rows as $r) {
                    DB::table($t)->where('id', $r->id)->update([
                        'slug' => json_encode(['sr' => (string) $r->slug], JSON_UNESCAPED_UNICODE),
                    ]);
                }
            });

            DB::statement("ALTER TABLE `{$t}` MODIFY `slug` JSON NULL");
        }
    }

    public function down(): void
    {
        foreach ($this->tabele as $t) {
            DB::statement("ALTER TABLE `{$t}` MODIFY `slug` TEXT NULL");
            DB::statement("UPDATE `{$t}` SET `slug` = JSON_UNQUOTE(JSON_EXTRACT(`slug`, '$.sr'))");
            DB::statement("ALTER TABLE `{$t}` MODIFY `slug` VARCHAR(255) NULL");

            Schema::table($t, function ($table) use ($t) {
                $table->unique('slug', "{$t}_slug_unique");
            });
        }
    }
};
