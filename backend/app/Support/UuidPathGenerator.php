<?php

namespace App\Support;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class UuidPathGenerator implements PathGenerator
{
    public function getPath(Media $media): string
    {
        return $this->kljuc($media).'/';
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->kljuc($media).'/conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->kljuc($media).'/responsive/';
    }

    protected function kljuc(Media $media): string
    {
        return $media->uuid ?: (string) $media->getKey();
    }
}
