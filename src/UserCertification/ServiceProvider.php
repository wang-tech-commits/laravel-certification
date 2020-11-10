<?php

namespace MrwangTc\UserCertification;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/config/config.php' => config_path('usercertification.php')]);
            $this->publishes([__DIR__ . '/database/migrations/' => database_path('migrations')]);
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/config/config.php', 'usercertification');
    }
}
