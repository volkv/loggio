### Loggio - is a simple event logger (`event:count`) for Laravel with a daily reports to Telegram

## Installation

```bash
composer require volkv/loggio "*"
```

```bash
php artisan migrate
````

You can optionally publish the config file with:

```bash
php artisan vendor:publish --provider="Volkv\Loggio\LoggioServiceProvider"
```

## Configuration

* Add Telegram credentials to your `.env`

```dotenv
LOGGIO_TELEGRAM_BOT_TOKEN=
LOGGIO_TELEGRAM_CHAT_ID=
```

* Add cron job to the `app/Console/Kernel.php`  scheduler with a preferable `->dailyAt()` option

```php
use Volkv\Loggio\Jobs\LoggioNotify;

 $schedule->job(new LoggioNotify)->environments(['production'])->dailyAt('6:30');
 ``` 
Please note, that you will get previous (since notify job moment) day's stats compared to 2 day before
## Usage

```php
use Volkv\Loggio\Loggio;

// Supported methods
Loggio::increment('your event');
Loggio::setCount('your event', 10);
Loggio::addCount('your event', 2);

// E.g. you may log API requests count
$response = $this->client->get($endpoint);
Loggio::increment('API Calls');
       
// You may also wrap the `LoggioNotify` job with your job to fill some daily data right before notification is sent
class MyNotifyJob
{
    use Dispatchable;

    public function handle()
    {
        $commentsCount = Comment::where('created_at', now()->subDay()->format('Y-m-d'))->count();
        Loggio::setCount("New comments", $commentsCount);

        LoggioNotify::dispatch();
    }
}
```
You will receive telegram notification in following format:
```
laravel-app@local: 

your event 1: 0️⃣ 🔴 -10
your event 2: 10 🟢 +6
your event 3: 10 🟠 0
```

---
Tested with MySQL and PostgreSQL
