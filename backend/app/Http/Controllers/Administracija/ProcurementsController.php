<?php

namespace App\Http\Controllers\Administracija;

use App\Models\Procurement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProcurementsController extends AdminResourceController
{
    protected function model(): string
    {
        return Procurement::class;
    }

    protected function view(): string
    {
        return 'Nabavke';
    }

    protected function base(): string
    {
        return 'nabavke';
    }

    protected function categoryType(): string
    {
        return '';
    }

    protected function tip(): string
    {
        return 'procurement';
    }

    protected function nazivJednine(): string
    {
        return 'Javna nabavka';
    }

    protected function propKey(): string
    {
        return 'nabavka';
    }

    protected function hasCategory(): bool
    {
        return false;
    }

    protected function hasMedia(): bool
    {
        return false;
    }

    protected function rules(?Model $model): array
    {
        return [
            'opis' => ['array'],
            'opis.*' => ['nullable', 'string'],
            'godina' => ['nullable', 'integer', 'min:2000', 'max:2100'],
            'datum' => ['nullable', 'date'],
        ];
    }

    protected function assign(Model $stavka, array $data): void
    {
        $stavka->setTranslations('opis', $this->trMap($data['opis'] ?? []));
        $stavka->godina = $data['godina'] ?? null;
        $stavka->datum = $data['datum'] ?? null;
    }

    protected function detaljiExtra(Model $stavka): array
    {
        return [
            'opis' => $stavka->getTranslations('opis'),
            'godina' => $stavka->godina,
            'datum' => $stavka->datum?->format('Y-m-d'),
            'dokumenti' => $stavka->getMedia('dokumenti')->map(fn (Media $m) => [
                'id' => $m->id,
                'naziv' => $m->name ?: $m->file_name,
                'url' => $m->getUrl(),
            ])->all(),
        ];
    }

    protected function rowPodnaslov(Model $stavka): string
    {
        return trim(collect([
            $stavka->godina,
            Str::limit(strip_tags($stavka->getTranslations('opis')['sr'] ?? ''), 70),
        ])->filter()->implode(' · '));
    }

    public function uploadDokument(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'dokument' => ['required', 'file', 'mimes:pdf', 'max:20480'],
        ]);

        $this->find($id)->addMediaFromRequest('dokument')->toMediaCollection('dokumenti');

        return back(303)->with('status', 'Dokument je dodan.');
    }

    public function destroyDokument(Media $media): RedirectResponse
    {
        abort_unless($media->model_type === Procurement::class && $media->collection_name === 'dokumenti', 404);

        $media->delete();

        return back(303)->with('status', 'Dokument je uklonjen.');
    }
}
