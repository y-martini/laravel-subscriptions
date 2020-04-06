<?php


namespace YuriyMartini\Subscriptions;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use YuriyMartini\Subscriptions\Contracts\Plan;
use YuriyMartini\Subscriptions\Traits\UsesModels;

/**
 * @property Collection subscriptions
 */
trait HasSubscriptions
{
    use UsesModels;

    /**
     * @return HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(static::getSubscriptionModel());
    }

    /**
     * Begin creating a new subscription.
     *
     * @param Plan $plan
     * @return SubscriptionBuilder
     */
    public function newSubscription(Plan $plan)
    {
        return new SubscriptionBuilder($this, $plan);
    }

    /**
     * Select the subscription for the given plan or null.
     *
     * @param Plan|null $plan
     * @return Contracts\Subscription|null
     */
    public function getSubscription(?Plan $plan = null)
    {
        /** @var Builder $query */
        $query = $this->subscriptions()->active();
        if (!is_null($plan)){
            $query->where('plan_id', $plan->getKey());
        }

        return $query->first();
    }

    /**
     * Determine if the user has a subscription for the given plan.
     *
     * @param Contracts\Plan|null $plan
     * @return bool
     */
    public function isSubscribed(?Contracts\Plan $plan = null)
    {
        /** @var Builder $query */
        $query = $this->subscriptions()->active();
        if (!is_null($plan)){
            $query->where('plan_id', $plan->getKey());
        }

        return $query->exists();
    }
}
