<?php

namespace YuriyMartini\Subscriptions;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use YuriyMartini\Subscriptions\Console\Commands\Expiring;
use YuriyMartini\Subscriptions\Contracts\Coupon as CouponContract;
use YuriyMartini\Subscriptions\Contracts\ExpiredNotification as ExpiredNotificationContract;
use YuriyMartini\Subscriptions\Contracts\ExpiringNotification as ExpiringNotificationContract;
use YuriyMartini\Subscriptions\Contracts\Plan as PlanContract;
use YuriyMartini\Subscriptions\Contracts\Service as ServiceContract;
use YuriyMartini\Subscriptions\Contracts\Subscription as SubscriptionContract;
use YuriyMartini\Subscriptions\Models\Coupon;
use YuriyMartini\Subscriptions\Models\Plan;
use YuriyMartini\Subscriptions\Models\Service;
use YuriyMartini\Subscriptions\Models\Subscription;
use YuriyMartini\Subscriptions\Notifications\ExpiredNotification;
use YuriyMartini\Subscriptions\Notifications\ExpiringNotification;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public $bindings = [
        CouponContract::class => Coupon::class,
        ExpiredNotificationContract::class => ExpiredNotification::class,
        ExpiringNotificationContract::class => ExpiringNotification::class,
        PlanContract::class => Plan::class,
        ServiceContract::class => Service::class,
        SubscriptionContract::class => Subscription::class,
    ];

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->bootMigrations();
        $this->loadFactories();
        $this->bootConfig();
        $this->bootCommands();
        $this->bootTranslations();
    }

    protected function bootMigrations()
    {
        $this->publishes([
            __DIR__ . '/../database/migrations/' => App::databasePath('migrations')
        ], ['migrations', 'subscriptions', 'subscriptions-migrations']);

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    private function bootConfig()
    {
        $this->publishes([
            __DIR__ . '/../config/subscriptions.php' => App::configPath('subscriptions.php'),
        ], ['subscriptions', 'config', 'subscriptions-config']);

        $this->mergeConfigFrom(
            __DIR__ . '/../config/subscriptions.php', 'subscriptions'
        );
    }

    protected function loadFactories()
    {
        $this->loadFactoriesFrom(__DIR__ . '/../database/factories');
    }

    protected function bootCommands()
    {
        $this->commands([
            Expiring::class,
        ]);
    }

    protected function bootTranslations()
    {
        $this->publishes([
            __DIR__ . '/../resources/lang/' => App::resourcePath('lang/vendor/subscriptions')
        ], ['translations', 'subscriptions', 'subscriptions-translations']);

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang/', 'subscriptions');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        //
    }
}
