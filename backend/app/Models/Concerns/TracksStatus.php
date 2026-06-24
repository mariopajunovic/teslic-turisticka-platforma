<?php

namespace App\Models\Concerns;

use App\Enums\ContentStatus;
use App\Notifications\ContentStatusChanged;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;

trait TracksStatus
{
    use LogsActivity;

    public static function bootTracksStatus(): void
    {
        static::updated(function ($model) {
            if (! $model->wasChanged('status') || ! $model->user_id) {
                return;
            }

            if (in_array($model->status, [ContentStatus::Objavljeno, ContentStatus::Odbijeno], true)) {
                $model->user?->notify(new ContentStatusChanged($model));
            }
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['status', 'published_at'])
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }
}
