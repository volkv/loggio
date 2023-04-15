### Loggio - is a simple events logger (`event:count`) with a daily reports to Telegram

## Installation

```bash
composer require volkv/loggio
```
```bash
php artisan migrate
````

You can optionally publish the config file with:
```bash
php artisan vendor:publish --provider="Volkv\Loggio\LoggioServiceProvider"
```

## Configuration

* Add  `new LoggioNotify` job to the `app/Console/Kernel.php` scheduler with a `->dailyAt()` option
* Add Telegram credentials to your `.env`
```dotenv
LOGGIO_TELEGRAM_BOT_TOKEN=
LOGGIO_TELEGRAM_CHAT_ID=
```
## Usage
```php
use Volkv\Loggio\Loggio;

Loggio::increment('your job');
Loggio::setCount('your job', 10);
Loggio::addCount('your job', 2);
```
