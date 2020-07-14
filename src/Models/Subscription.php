<?php

namespace YuriyMartini\Subscriptions\Models;

use Illuminate\Database\Eloquent\Model;
use YuriyMartini\Subscriptions\Contracts\HasSubscriptions;
use YuriyMartini\Subscriptions\Contracts\Plan as PlanContract;
use YuriyMartini\Subscriptions\Contracts\Subscription as SubscriptionContract;
use YuriyMartini\Subscriptions\Traits\HasContractsBindings;

/**
 * @property string status
 * @property PlanContract plan
 * @property HasSubscriptions $customer
 */
class Subscription extends Model implements SubscriptionContract
{
    use HasContractsBindings;

    protected $dates = [
        'start_date',
        'end_date',
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

    public function user()
    {
        return $this->belongsTo(static::getHasSubscriptionsContractBinding(), static::resolveHasSubscriptionsContract()->getForeignKey());
    }
}
