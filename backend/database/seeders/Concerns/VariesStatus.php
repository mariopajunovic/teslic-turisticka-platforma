<?php

namespace Database\Seeders\Concerns;

use App\Enums\ContentStatus;

trait VariesStatus
{
    protected function statusFor(int $i): ContentStatus
    {
        return match ($i) {
            1 => ContentStatus::Poslano,
            4 => ContentStatus::Nacrt,
            5 => ContentStatus::Odbijeno,
            default => ContentStatus::Objavljeno,
        };
    }

    protected function statusFields(int $i): array
    {
        $status = $this->statusFor($i);

        return [
            'status' => $status,
            'published_at' => $status === ContentStatus::Objavljeno ? now() : null,
            'rejection_reason' => $status === ContentStatus::Odbijeno
                ? 'Potrebne kvalitetnije fotografije i detaljniji opis prije objave.'
                : null,
        ];
    }
}
