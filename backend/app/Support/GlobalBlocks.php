<?php

namespace App\Support;

use App\Models\GlobalBlock;

class GlobalBlocks
{
    /**
     * Zamijeni blokove koji su vezani na globalni blok (global_id) njegovim aktuelnim sadržajem.
     * $zaEditor: dodaje globalNaziv za prikaz u builderu.
     */
    public static function resolve(array $blocks, bool $zaEditor = false): array
    {
        $ids = collect($blocks)->pluck('global_id')->filter()->unique()->all();

        if (! $ids) {
            return $blocks;
        }

        $globalni = GlobalBlock::whereIn('id', $ids)->get()->keyBy('id');

        return collect($blocks)->map(function (array $blok) use ($globalni, $zaEditor) {
            $gid = $blok['global_id'] ?? null;

            if (! $gid) {
                return $blok;
            }

            if (! $globalni->has($gid)) {
                unset($blok['global_id']);

                return $blok;
            }

            $g = $globalni->get($gid);
            $blok['type'] = $g->type;
            $blok['data'] = (array) ($g->data ?? []);
            $blok['global_id'] = (int) $gid;

            if ($zaEditor) {
                $blok['globalNaziv'] = $g->name;
            }

            return $blok;
        })->all();
    }
}
