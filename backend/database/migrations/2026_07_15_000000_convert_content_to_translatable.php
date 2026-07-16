<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    protected array $stringFields = [
        'pages' => ['title', 'meta_title', 'meta_description'],
        'places' => ['naziv'],
        'events' => ['naslov', 'opis', 'opis_dug', 'lokacija', 'organizator'],
        'news' => ['naslov', 'izvod', 'sadrzaj'],
        'stories' => ['naslov', 'izvod', 'sadrzaj', 'autor', 'autor_bio'],
        'categories' => ['label', 'opis', 'meta_title', 'meta_description'],
        'menus' => ['name'],
        'menu_items' => ['label'],
        'businesses' => ['naslov', 'opis', 'opis_dug', 'lokacija'],
        'locations' => ['naslov', 'opis', 'opis_dug', 'lokacija', 'kako_doci', 'savjeti', 'sezona', 'radno_vrijeme', 'ulaznice'],
        'ads' => ['naslov', 'izdavac', 'lokacija', 'opis_dug'],
        'tags' => ['name'],
    ];

    protected array $jsonFields = [
        'pages' => ['content'],
    ];

    public function up(): void
    {
        foreach ($this->stringFields as $table => $cols) {
            foreach ($cols as $col) {
                DB::statement("ALTER TABLE `{$table}` MODIFY `{$col}` LONGTEXT NULL");
                DB::statement("UPDATE `{$table}` SET `{$col}` = JSON_OBJECT('sr', `{$col}`) WHERE `{$col}` IS NOT NULL AND (JSON_VALID(`{$col}`) = 0 OR JSON_TYPE(`{$col}`) <> 'OBJECT')");
                DB::statement("ALTER TABLE `{$table}` MODIFY `{$col}` JSON NULL");
            }
        }

        foreach ($this->jsonFields as $table => $cols) {
            foreach ($cols as $col) {
                DB::statement("UPDATE `{$table}` SET `{$col}` = JSON_OBJECT('sr', `{$col}`) WHERE `{$col}` IS NOT NULL AND JSON_TYPE(`{$col}`) <> 'OBJECT'");
            }
        }
    }

    public function down(): void
    {
        foreach ($this->stringFields as $table => $cols) {
            foreach ($cols as $col) {
                DB::statement("ALTER TABLE `{$table}` MODIFY `{$col}` LONGTEXT NULL");
                DB::statement("UPDATE `{$table}` SET `{$col}` = JSON_UNQUOTE(JSON_EXTRACT(`{$col}`, '$.sr')) WHERE `{$col}` IS NOT NULL AND JSON_VALID(`{$col}`) = 1 AND JSON_TYPE(`{$col}`) = 'OBJECT'");
            }
        }

        foreach ($this->jsonFields as $table => $cols) {
            foreach ($cols as $col) {
                DB::statement("UPDATE `{$table}` SET `{$col}` = JSON_EXTRACT(`{$col}`, '$.sr') WHERE `{$col}` IS NOT NULL AND JSON_TYPE(`{$col}`) = 'OBJECT'");
            }
        }
    }
};
