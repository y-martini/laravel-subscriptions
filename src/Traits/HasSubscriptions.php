<?php

namespace YuriyMartini\Subscriptions\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use YuriyMartini\Subscriptions\Enums\SubscriptionStatus;

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

    public function hasActiveSubscriptions()
    {
        return $this->subscriptions()->where('status', SubscriptionStatus::ACTIVE)->exists();
    }

    /**
     * @param  Builder|QueryBuilder  $query
     * @param  bool  $not
     */
    public static function scopeActiveSubscriptions($query, bool $not = false)
    {
        $query
            ->whereExists(function (QueryBuilder $query) {
                $hasSubscriptions = static::resolveHasSubscriptionsContract();
                $subscription = static::resolveSubscriptionContract();

                $query
                    ->select(DB::raw(1))
                    ->from($subscription->getTable())
                    ->whereRaw("{$hasSubscriptions->getTable()}.{$hasSubscriptions->getKeyName()} = {$subscription->getTable()}.{$hasSubscriptions->getForeignKey()}")
                    ->where("{$subscription->getTable()}.status", SubscriptionStatus::ACTIVE);
            }, 'and', $not);
    }
}
