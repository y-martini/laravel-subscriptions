<?php

namespace YuriyMartini\Subscriptions\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use YuriyMartini\Subscriptions\Contracts\ExpiredNotification;
use YuriyMartini\Subscriptions\Contracts\Subscription;
use YuriyMartini\Subscriptions\Enums\SubscriptionStatus;
use YuriyMartini\Subscriptions\Traits\InteractsWithContractsBindings;

class Expired extends Command
{
    use InteractsWithContractsBindings;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks, updates status and notifies customers about their expired subscriptions.';

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
                    && $subscription->getEndDate()->isPast()
                    && (
                        is_null($subscription->getExpiredNotificationDate())
                        || !$subscription->getExpiredNotificationDate()->isAfter($subscription->getEndDate())
                    );
            });

        $this->output->text("Found {$subscriptions->count()} expired subscriptions to update and notify.");

        $subscriptions
            ->each(function (Subscription $subscription){
                $notification = Container::getInstance()
                    ->make(ExpiredNotification::class, [$subscription]);

                $subscription->getCustomer()->notify($notification);
                $subscription->setExpiredNotificationDate(Carbon::today());
                $subscription->setStatus(SubscriptionStatus::EXPIRED());
            });

        $this->output->success('Done.');
    }
}
