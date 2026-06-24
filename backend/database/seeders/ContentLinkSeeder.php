<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\ContentLink;
use App\Models\Event;
use App\Models\Location;
use App\Models\Story;
use Illuminate\Database\Seeder;

class ContentLinkSeeder extends Seeder
{
    public function run(): void
    {
        $this->link(Business::class, 'stari-zanati-borje', Story::class, 'ljudi-duh-teslica');
        $this->link(Location::class, 'planina-borja', Event::class, 'ljeto-na-borju');
        $this->link(Location::class, 'planina-borja', Story::class, 'ljudi-duh-teslica');
    }

    protected function link(string $sourceModel, string $sourceSlug, string $targetModel, string $targetSlug): void
    {
        $source = $sourceModel::where('slug', $sourceSlug)->first();
        $target = $targetModel::where('slug', $targetSlug)->first();

        if (! $source || ! $target) {
            return;
        }

        ContentLink::firstOrCreate([
            'source_type' => $sourceModel,
            'source_id' => $source->id,
            'target_type' => $targetModel,
            'target_id' => $target->id,
        ]);
    }
}
