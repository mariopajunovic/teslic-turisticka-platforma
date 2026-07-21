<?php

namespace Database\Seeders;

use App\Models\Translation;
use Illuminate\Database\Seeder;

class TranslationSeeder extends Seeder
{
    public function run(): void
    {
        $path = storage_path('app/translations-import.json');

        if (! file_exists($path)) {
            $this->command->warn('Nema translations-import.json - preskačem uvoz prevoda.');

            return;
        }

        $rows = json_decode(file_get_contents($path), true) ?: [];

        foreach ($rows as $r) {
            Translation::updateOrCreate(
                ['key' => $r['key']],
                ['group' => $r['group'] ?? explode('.', $r['key'])[0], 'values' => $r['values']]
            );
        }

        $this->command->info('Uvezeno prevoda: '.count($rows));
    }
}
