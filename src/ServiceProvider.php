<?php
namespace YuriyMartini\Subscriptions;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->config();

        $this->migrations();
    }

    private function config()
    {
        $this->publishes([
            __DIR__ . '/../config/subscriptions.php' => App::configPath('subscriptions.php'),
        ], ['subscriptions', 'config', 'subscriptions-config']);

        $this->mergeConfigFrom(
            __DIR__ . '/../config/subscriptions.php', 'subscriptions'
        );
    }

    private function migrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations/2020_01_01_000100_create_subscriptions_services_table.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations/2020_01_01_000200_create_subscriptions_plans_table.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations/2020_01_01_000300_create_subscriptions_subscriptions_table.php');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        //
    }
}
