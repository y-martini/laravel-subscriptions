<?php

namespace YuriyMartini\Subscriptions\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use YuriyMartini\Subscriptions\Contracts\Plan as PlanContract;
use YuriyMartini\Subscriptions\Contracts\Service;
use YuriyMartini\Subscriptions\Traits\HasContractsBindings;

/**
 * @property Service service
 * @property string key
 * @property string name
 * @property Collection subscriptions
 */
class Plan extends Model implements PlanContract
{
    use HasContractsBindings;

    public function getService(): Service
    {
        return $this->service;
    }

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
        return $this->hasMany(static::getSubscriptionContractBinding(), static::resolveSubscriptionContract()->getForeignKey());
    }
}
