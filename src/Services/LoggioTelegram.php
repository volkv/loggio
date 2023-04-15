<?php

namespace Volkv\Loggio\Services;

use Illuminate\Support\Facades\Http;

class LoggioTelegram
{

    public static function send($message): void
    {

        $chatID = config('loggio.telegram_chat_id');
        $botToken = config('loggio.telegram_bot_token');
        $message = urlencode($message);

        Http::get("https://api.telegram.org/bot{$botToken}/sendMessage?chat_id={$chatID}&text={$message}");

    }
}
