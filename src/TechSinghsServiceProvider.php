<?php

declare(strict_types=1);

namespace MobiMarket\TechSinghs;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use MobiMarket\TechSinghs\TechSinghs;

class TechSinghsServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @deprecated
     */
    protected $defer = true;

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/techsinghs.php' => config_path('techsinghs.php'),
        ], 'techsinghs');
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/techsinghs.php', 'techsinghs');

        $this->app->singleton(TechSinghs::class, function (Application $app) {
            $config = $app->make('config');

            return new TechSinghs(
                $config->get('techsinghs.api_key'),
                $config->get('techsinghs.timeout')
            );
        });
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [TechSinghs::class];
    }
}
