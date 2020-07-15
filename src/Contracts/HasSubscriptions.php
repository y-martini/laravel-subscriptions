<?php

namespace YuriyMartini\Subscriptions\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface HasSubscriptions extends Model
{
    public function getSubscriptions(): Collection;

    /**
     * @param  Subscription  $subscription
     * @return string|null
     */
    public function getSubscriptionUrl(Subscription $subscription): ?string;

    /**
     * Send the given notification.
     *
     * @param  mixed  $instance
     * @return void
     */
    public function notify($instance);
}
