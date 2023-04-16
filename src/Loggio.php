<?php

namespace Volkv\Loggio;

use Carbon\Carbon;
use Volkv\Loggio\Models\LoggioModel;

class Loggio
{

    static function increment(string $eventName): void
    {

        self::addCount($eventName, 1);

    }

    static function addCount(string $eventName, int $add): void
    {

        if (!self::shouldRun()) {
            return;
        }

        $record = self::getRecordByEventName($eventName);
        $record->count = $record->count ? $record->count + $add : $add;
        $record->saveQuietly();

    }


    static function setCount(string $eventName, int $count): void
    {

        if (!self::shouldRun()) {
            return;
        }

        $record = self::getRecordByEventName($eventName);
        $record->count = $count;
        $record->saveQuietly();

    }

    private static function getRecordByEventName(string $event_name): LoggioModel
    {

        $date = Carbon::now()->timezone(config('loggio.timezone', 'UTC'))->format('Y-m-d');

        return LoggioModel::firstOrNew(compact('date', 'event_name'));

    }

    private static function shouldRun(): bool
    {
        return !(config('loggio.production_only', true) && !app()->isProduction());
    }

}
