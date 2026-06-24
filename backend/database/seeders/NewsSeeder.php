<?php

namespace Database\Seeders;

use App\Enums\ContentStatus;
use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        News::updateOrCreate(
            ['slug' => 'turisticka-sezona-u-teslicu-rekordna-posjeta'],
            [
                'user_id' => null,
                'naslov' => 'Turistička sezona u Tesliću: rekordna posjeta',
                'izvod' => 'Ovo ljeto donijelo je rekordne rezultate u turističkim dolascima na području Teslića, prema podacima Turističke organizacije.',
                'sadrzaj' => '<p>Turistička organizacija Teslić saopštila je da je u toku ljetne sezone zabilježen rekordni broj posjetilaca. Kapaciteti smještajnih objekata su popunjeni, a gosti posebno cijene prirodne ljepote i mir ovog kraja.</p><p>Posebno popularni su izletišta na Borju i termalna banja, koje privlače goste iz čitave regije. Organizatori najavljuju nove sadržaje i projekte za narednu sezonu.</p>',
                'datum' => now()->subDays(10)->toDateString(),
                'status' => ContentStatus::Objavljeno,
                'published_at' => now()->subDays(10),
            ],
        );

        News::updateOrCreate(
            ['slug' => 'novi-pješacki-put-na-borju-otvoren-za-posjetioce'],
            [
                'user_id' => null,
                'naslov' => 'Novi pješački put na Borju otvoren za posjetioce',
                'izvod' => 'Opština Teslić svečano je otvorila novi pješački put na planini Borje, koji nudi spektakularne poglede na okolinu.',
                'sadrzaj' => '<p>Na planini Borje svečano je otvoren novi pješački put dužine 4,5 km. Put prolazi kroz borove šume i nudi mehroja osmatračnica sa pogledom na dolinu rijeke Usore i okolna sela.</p><p>Gradonačelnik Teslića pozvao je sve ljubitelje prirode da iskoriste ovu prilike i posjete novu atrakciju. Put je prilagođen i za planinske bicikliste.</p>',
                'datum' => now()->subDays(3)->toDateString(),
                'status' => ContentStatus::Objavljeno,
                'published_at' => now()->subDays(3),
            ],
        );
    }
}
