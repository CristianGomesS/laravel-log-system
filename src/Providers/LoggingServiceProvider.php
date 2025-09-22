<?php

namespace Carcara\SystemLog\Providers;

use Illuminate\Support\ServiceProvider;
use Carcara\SystemLog\Http\Middleware\AccessLogMiddleware;
use Carcara\SystemLog\Repositories\Contracts\AccessLogRepositoryInterface;
use Carcara\SystemLog\Repositories\Core\AccessLogRepository;

class LoggingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/access-log.php', 'access-log'
        );

        $this->app->bind(AccessLogRepositoryInterface::class, AccessLogRepository::class);
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../../config/access-log.php' => config_path('access-log.php'),
        ], 'config');

        $router = $this->app->make(\Illuminate\Routing\Router::class);
        $router->aliasMiddleware('access.log', AccessLogMiddleware::class);
    }
}