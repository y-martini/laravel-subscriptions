<?php

namespace YuriyMartini\Subscriptions\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use YuriyMartini\Subscriptions\Contracts\Coupon as CouponContract;
use YuriyMartini\Subscriptions\Traits\InteractsWithContractsBindings;

/**
 * @property string name
 * @property Collection subscriptions
 */
class Coupon extends Model implements CouponContract
{
    use InteractsWithContractsBindings;

    public function getSubscriptions(): Collection
    {
        return $this->subscriptions;
    }

    public function service()
    {
        return $this->belongsTo(static::getServiceContractBinding(), static::resolveServiceContract()->getForeignKey());
    }

    public function subscriptions()
    {
        return $this->belongsToMany(static::getSubscriptionContractBinding());
    }
}
