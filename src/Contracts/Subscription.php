<?php

namespace YuriyMartini\Subscriptions\Contracts;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use YuriyMartini\Subscriptions\Enums\SubscriptionStatus;

interface Subscription extends Model
{
    public function getPlan(): Plan;

    public function getCustomer(): HasSubscriptions;

    public function getStartDate(): Carbon;

    public function getEndDate(): Carbon;

    public function getExpiringNotificationDate(): ?Carbon;

    public function setExpiringNotificationDate(Carbon $date);

    public function getStatus(): SubscriptionStatus;

    public function getCoupons(): Collection;
}
