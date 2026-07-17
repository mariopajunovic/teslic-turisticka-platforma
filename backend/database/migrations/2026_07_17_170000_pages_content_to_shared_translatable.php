<?php

use App\Support\BlockContent;
use App\Support\BlockSchema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('pages')->orderBy('id')->get()->each(function ($row) {
            $content = json_decode($row->content ?? '[]', true) ?: [];

            if (isset($content['sr']) && is_array($content['sr'])) {
                $blocks = $content['sr'];
            } elseif (array_is_list($content)) {
                $blocks = $content;
            } else {
                $blocks = [];
            }

            $wrapped = array_map(fn ($b) => is_array($b) ? BlockSchema::wrapBlock($b) : $b, $blocks);

            DB::table('pages')->where('id', $row->id)->update([
                'content' => json_encode($wrapped, JSON_UNESCAPED_UNICODE),
            ]);
        });
    }

    public function down(): void
    {
        DB::table('pages')->orderBy('id')->get()->each(function ($row) {
            $blocks = json_decode($row->content ?? '[]', true) ?: [];

            if (isset($blocks['sr'])) {
                return;
            }

            $unwrapped = array_is_list($blocks) ? BlockContent::resolve($blocks, 'sr') : [];

            DB::table('pages')->where('id', $row->id)->update([
                'content' => json_encode(['sr' => $unwrapped], JSON_UNESCAPED_UNICODE),
            ]);
        });
    }
};
