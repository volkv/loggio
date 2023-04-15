<?php

namespace Volkv\Loggio;

use Illuminate\Support\ServiceProvider;

class LoggioServiceProvider extends ServiceProvider
{

    public function boot()
    {

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->publishes([__DIR__ . '/../config/loggio.php' => config_path('loggio.php')]);

    }


}
