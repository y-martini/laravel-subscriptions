<?php

namespace YuriyMartini\Subscriptions\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use YuriyMartini\Subscriptions\Contracts\HasSubscriptions;
use YuriyMartini\Subscriptions\Contracts\Plan as PlanContract;
use YuriyMartini\Subscriptions\Contracts\Subscription as SubscriptionContract;
use YuriyMartini\Subscriptions\Enums\SubscriptionStatus;
use YuriyMartini\Subscriptions\Traits\InteractsWithContractsBindings;

/**
 * @property string status
 * @property PlanContract|Model plan
 * @property HasSubscriptions|Model customer
 * @property Carbon start_date
 * @property Carbon end_date
 * @property Carbon|null expiring_notification_date
 * @property Carbon|null expired_notification_date
 * @property Collection coupons
 */
class Subscription extends Model implements SubscriptionContract
{
    use InteractsWithContractsBindings;

    protected static $unguarded = true;

    protected $dates = [
        'start_date',
        'end_date',
        'expiring_notification_date',
    ];

    public function getPlan(): PlanContract
    {
        return $this->plan;
    }

    public function getCustomer(): HasSubscriptions
    {
        return $this->customer;
    }

    public function plan()
    {
        return $this->belongsTo(static::getPlanContractBinding(), static::resolvePlanContract()->getForeignKey());
    }

    public function customer()
    {
        return $this->belongsTo(static::getHasSubscriptionsContractBinding(), static::resolveHasSubscriptionsContract()->getForeignKey());
    }

    public function coupons()
    {
        return $this->belongsToMany(static::getCouponContractBinding());
    }

    public function getStartDate(): Carbon
    {
        return $this->start_date;
    }

    public function getEndDate(): Carbon
    {
        return $this->end_date;
    }

    public function getExpiringNotificationDate(): ?Carbon
    {
        return $this->expiring_notification_date;
    }

    public function setExpiringNotificationDate(Carbon $date)
    {
        $this->update(['expiring_notification_date' => $date]);
    }

    public function getExpiredNotificationDate(): ?Carbon
    {
        return $this->expired_notification_date;
    }

    public function setExpiredNotificationDate(Carbon $date)
    {
        $this->update(['expired_notification_date' => $date]);
    }

    public function getStatus(): SubscriptionStatus
    {
        return SubscriptionStatus::create($this->status);
    }

    public function setStatus(SubscriptionStatus $status)
    {
        $this->update(['status' => $status->value()]);
    }

    public function getCoupons(): Collection
    {
        return $this->coupons;
    }
}
