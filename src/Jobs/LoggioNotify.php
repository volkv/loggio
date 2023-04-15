<?php


namespace Volkv\Loggio\Jobs;

use Illuminate\Foundation\Bus\Dispatchable;
use Volkv\Loggio\Models\LoggioModel;
use Volkv\Loggio\Services\LoggioTelegram;

class LoggioNotify
{
    use Dispatchable;

    public function handle()
    {

        $message = config('app.name').'@'.app()->environment().': '.PHP_EOL.PHP_EOL;

        $allSlugs = LoggioModel::select('activity_slug')->distinct()->pluck('activity_slug')->toArray();


        $items = LoggioModel::where('date', now()->format('Y-m-d'))->pluck('count', 'activity_slug');
        $prevItems = LoggioModel::where('date', now()->subDay()->format('Y-m-d'))->pluck('count', 'activity_slug');

        foreach ($allSlugs as $slug) {
            $items[$slug] = $items[$slug] ?? 0;
        }

        foreach ($items as $slug => $count) {

            $prevCount = $prevItems[$slug] ?? 0;
            $diff = $count - $prevCount;
            $diff = $diff > 0 ? "+{$diff}" : $diff;

            $message .= "$slug: $count | $diff".PHP_EOL;
        }


        LoggioTelegram::send($message);
    }

}
