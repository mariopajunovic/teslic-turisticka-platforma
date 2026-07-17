<?php

namespace App\Support;

use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Activity;

class ActivityPresenter
{
    public function present(Activity $a): array
    {
        $auth = $a->log_name === 'auth';

        return [
            'id' => $a->id,
            'time' => $a->created_at?->diffForHumans(),
            'icon' => $this->icon($a, $auth),
            'boja' => $this->boja($a, $auth),
            'naslov' => $this->naslov($a, $auth),
            'izmjene' => $this->izmjene($a),
        ];
    }

    protected function naslov(Activity $a, bool $auth): string
    {
        if ($auth) {
            return $a->description === 'Odjava' ? 'Odjava iz panela' : 'Prijava u panel';
        }

        return match ($a->event) {
            'created' => 'Kreiranje',
            'updated' => 'Izmjena',
            'deleted' => 'Brisanje',
            default => (string) $a->description,
        };
    }

    protected function icon(Activity $a, bool $auth): string
    {
        if ($auth) {
            return 'log-in';
        }

        return match ($a->event) {
            'created' => 'plus',
            'updated' => 'pencil',
            'deleted' => 'trash-2',
            default => 'activity',
        };
    }

    protected function boja(Activity $a, bool $auth): string
    {
        if ($auth) {
            return 'info';
        }

        return match ($a->event) {
            'created' => 'ok',
            'deleted' => 'bad',
            default => 'brand',
        };
    }

    public function izmjene(Activity $a): array
    {
        $props = $a->properties;
        $novo = (array) (is_object($props) || is_array($props) ? ($props['attributes'] ?? []) : []);
        $staro = (array) (is_object($props) || is_array($props) ? ($props['old'] ?? []) : []);

        $out = [];

        foreach (array_keys($novo ?: $staro) as $polje) {
            $out[] = [
                'polje' => Str::ucfirst(str_replace('_', ' ', (string) $polje)),
                'staro' => array_key_exists($polje, $staro) ? $this->formatVrijednost($staro[$polje]) : null,
                'novo' => array_key_exists($polje, $novo) ? $this->formatVrijednost($novo[$polje]) : null,
            ];
        }

        return $out;
    }

    protected function formatVrijednost($v): string
    {
        if (is_null($v)) {
            return '-';
        }

        if (is_bool($v)) {
            return $v ? 'Da' : 'Ne';
        }

        if (is_string($v)) {
            $decoded = json_decode($v, true);

            if (is_array($decoded)) {
                $v = $decoded;
            }
        }

        if (is_array($v)) {
            $v = $v['sr'] ?? (reset($v) ?: '');
        }

        $s = (string) $v;

        return $s === '' ? '-' : $s;
    }
}
