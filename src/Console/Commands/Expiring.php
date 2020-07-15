<?php

namespace YuriyMartini\Subscriptions\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use YuriyMartini\Subscriptions\Contracts\ExpiringNotification;
use YuriyMartini\Subscriptions\Contracts\Subscription;
use YuriyMartini\Subscriptions\Enums\SubscriptionStatus;
use YuriyMartini\Subscriptions\Traits\InteractsWithContractsBindings;

class Expiring extends Command
{
    use InteractsWithContractsBindings;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:expiring';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks and notifies customers about their expiring subscriptions.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /** @var Collection $subscriptions */
        $subscriptions = static::resolveSubscriptionContract()::query()->get()
            ->filter(function (Subscription $subscription){
                return
                    $subscription->getStatus()->equals(SubscriptionStatus::ACTIVE())
                    && !$subscription->getStartDate()->isFuture()
                    && $subscription->getEndDate()->subDays(Config::get('subscriptions.expiring_notification_interval'))->isToday()
                    && (
                        is_null($subscription->getExpiringNotificationDate())
                        || !$subscription->getExpiringNotificationDate()->isToday()
                    );
            });

        $this->output->text("Found {$subscriptions->count()} expiring subscriptions to notify.");

        $subscriptions
            ->each(function (Subscription $subscription){
                $notification = Container::getInstance()
                    ->make(ExpiringNotification::class, [$subscription]);

                $subscription->getCustomer()->notify($notification);
                $subscription->setExpiringNotificationDate(Carbon::today());
            });

        $this->output->success('Done.');
    }
}
