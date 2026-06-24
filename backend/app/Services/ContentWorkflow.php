<?php

namespace App\Services;

use App\Enums\ContentStatus;
use Illuminate\Database\Eloquent\Model;

class ContentWorkflow
{
    public function submit(Model $content): void
    {
        $content->update(['status' => ContentStatus::Poslano]);
    }

    public function approve(Model $content): void
    {
        $content->update([
            'status' => ContentStatus::Objavljeno,
            'published_at' => $content->published_at ?? now(),
        ]);
    }

    public function returnForRevision(Model $content, string $reason): void
    {
        $content->update([
            'status' => ContentStatus::Nacrt,
            'rejection_reason' => $reason,
        ]);
    }

    public function reject(Model $content, string $reason): void
    {
        $content->update([
            'status' => ContentStatus::Odbijeno,
            'rejection_reason' => $reason,
        ]);
    }

    public function archive(Model $content): void
    {
        $content->update(['status' => ContentStatus::Arhivirano]);
    }
}
