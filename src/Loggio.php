<?php

namespace Volkv\Loggio;

use Carbon\Carbon;
use Volkv\Loggio\Models\LoggioModel;

class Loggio
{

    static function increment(string $activitySlug): void
    {

        self::addCount($activitySlug, 1);

    }

    static function addCount(string $activitySlug, int $add): void
    {

        if (!self::shouldRun()) {
            return;
        }

        $record = self::getRecordBySlug($activitySlug);
        $record->count = $record->count ? $record->count + $add : $add;
        $record->saveQuietly();

    }


    static function setCount(string $activitySlug, int $count): void
    {

        if (!self::shouldRun()) {
            return;
        }

        $record = self::getRecordBySlug($activitySlug);
        $record->count = $count;
        $record->saveQuietly();

    }

    private static function getRecordBySlug(string $activity_slug): LoggioModel
    {

        $date = Carbon::now()->timezone(config('loggio.timezone', 'UTC'))->format('Y-m-d');

        return LoggioModel::firstOrNew(compact('date', 'activity_slug'));

    }

    private static function shouldRun(): bool
    {
        return !(config('loggio.production_only', true) && !app()->isProduction());
    }

}
