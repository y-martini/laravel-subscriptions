<?php

namespace YuriyMartini\Subscriptions;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use YuriyMartini\Subscriptions\Traits\HasContractsBindings;

/**
 * @mixin Model
 * @property Collection subscriptions
 */
trait HasSubscriptions
{
    use HasContractsBindings;

    public function getSubscriptions(): Collection
    {
        return $this->subscriptions;
    }

    /**
     * @return HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(static::getSubscriptionContractBinding());
    }
}
