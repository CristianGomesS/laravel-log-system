<?php

namespace Vendor\SystemLog\Providers;

use Illuminate\Support\ServiceProvider;
use Vendor\SystemLog\Http\Middleware\AccessLogMiddleware;
use Vendor\SystemLog\Repositories\Contracts\AccessLogRepositoryInterface;
use Vendor\SystemLog\Repositories\File\AccessLogRepository;

class LoggingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/access-log.php', 'access-log'
        );

        // CORREÇÃO: Usando o nome correto da interface no bind
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