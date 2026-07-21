<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\URL;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SecureMediaController extends Controller
{
    protected const KOLEKCIJE = ['naslovna_pending', 'galerija_pending'];

    public function show(Media $media): BinaryFileResponse
    {
        abort_unless(in_array($media->collection_name, self::KOLEKCIJE, true), 404);

        return response()->file($media->getPath());
    }

    public static function url(Media $media): string
    {
        return URL::temporarySignedRoute('mediji.pregled', now()->addHours(6), ['media' => $media->id]);
    }
}
