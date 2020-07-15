<?php

namespace YuriyMartini\Subscriptions\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin Model
 * @property Collection subscriptions
 */
trait HasSubscriptions
{
    use InteractsWithContractsBindings;

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
