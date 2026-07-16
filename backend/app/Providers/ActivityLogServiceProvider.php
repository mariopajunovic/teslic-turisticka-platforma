<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class ActivityLogServiceProvider extends ServiceProvider
{
    protected array $skip = [
        Activity::class,
        \App\Models\Admin::class,
        \Spatie\Permission\Models\Role::class,
        \Spatie\Permission\Models\Permission::class,
        \Spatie\MediaLibrary\MediaCollections\Models\Media::class,
    ];

    protected array $skipAttributes = [
        'password',
        'remember_token',
        'app_authentication_secret',
        'app_authentication_recovery_codes',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'updated_at',
        'created_at',
    ];

    protected array $events = [
        'eloquent.created: *' => 'created',
        'eloquent.updated: *' => 'updated',
        'eloquent.deleted: *' => 'deleted',
    ];

    public function boot(): void
    {
        foreach ($this->events as $pattern => $event) {
            Event::listen($pattern, function (string $eventName, array $data) use ($event): void {
                $model = $data[0] ?? null;

                if ($model instanceof Model) {
                    $this->record($model, $event);
                }
            });
        }
    }

    protected function record(Model $model, string $event): void
    {
        if ($this->shouldSkip($model)) {
            return;
        }

        $properties = [
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ];

        if ($event === 'updated') {
            $changes = Arr::except($model->getChanges(), $this->skipAttributes);

            if (empty($changes)) {
                return;
            }

            $properties['attributes'] = $changes;
            $properties['old'] = Arr::only($model->getOriginal(), array_keys($changes));
        } elseif ($event === 'created') {
            $properties['attributes'] = Arr::except($model->getAttributes(), $this->skipAttributes);
        } elseif ($event === 'deleted') {
            $properties['old'] = Arr::except($model->getOriginal(), $this->skipAttributes);
        }

        activity('sistem')
            ->performedOn($model)
            ->causedBy(auth('admin')->user() ?? auth('web')->user())
            ->event($event)
            ->withProperties($properties)
            ->log($this->description($model, $event));
    }

    protected function shouldSkip(Model $model): bool
    {
        if ($model instanceof Pivot) {
            return true;
        }

        foreach ($this->skip as $class) {
            if ($model instanceof $class) {
                return true;
            }
        }

        return in_array(LogsActivity::class, class_uses_recursive($model), true);
    }

    protected function description(Model $model, string $event): string
    {
        $glagol = match ($event) {
            'created' => 'Kreiran',
            'updated' => 'Izmijenjen',
            'deleted' => 'Obrisan',
            default => $event,
        };

        return $glagol.' '.class_basename($model).' #'.$model->getKey();
    }
}
