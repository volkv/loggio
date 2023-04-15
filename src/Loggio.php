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

        $record = self::getRecordBySlug($activitySlug);
        $record->increment('count', $add);
        $record->saveQuietly();

    }


    static function setCount(string $activitySlug, int $count): void
    {

        $record = self::getRecordBySlug($activitySlug);
        $record->count = $count;
        $record->saveQuietly();

    }

    private static function getRecordBySlug(string $activity_slug): LoggioModel
    {

        $date = Carbon::now()->timezone(config('loggio.timezone', 'UTC'))->format('Y-m-d');

        return LoggioModel::firstOrNew(compact('date','activity_slug'));

    }

}
