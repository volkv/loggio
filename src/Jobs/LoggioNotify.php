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

        // Clean old entries
        LoggioModel::where('date', '<', now()->subWeek()->format('Y-m-d'))->delete();

        $message = config('app.name') . '@' . app()->environment() . ': ' . PHP_EOL . PHP_EOL;

        $allSlugs = LoggioModel::select('event_name')->distinct()->pluck('event_name')->toArray();

        $entries = LoggioModel::where('date', now()->subDay()->format('Y-m-d'))->pluck('count', 'event_name')->toArray();
        $prevItems = LoggioModel::where('date', now()->subDays(2)->format('Y-m-d'))->pluck('count', 'event_name');

        foreach ($allSlugs as $slug) {
            $entries[$slug] = $entries[$slug] ?? 0;
        }

        ksort($entries);

        foreach ($entries as $slug => $count) {

            $prevCount = $prevItems[$slug] ?? 0;
            $diff = $count - $prevCount;

            $count = $count == 0 ? "0️⃣" : $count;
            $icon = "🟠 ";
            if ($diff > 0) {
                $icon = "🟢 +";
            } elseif ($diff < 0) {
                $icon = "🔴 ";
            }
            $message .= "{$slug}: {$count} {$icon}{$diff}" . PHP_EOL;
        }

        LoggioTelegram::send($message);
    }

}
