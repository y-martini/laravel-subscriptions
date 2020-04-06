<?php


namespace YuriyMartini\Subscriptions\Contracts;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface Subscription extends Model
{
    /**
     * @return BelongsTo
     */
    public function user();

    /**
     * @return BelongsTo
     */
    public function plan();

    public function ScopeActive(Builder $query);

    /**
     * Determine if the subscription is active.
     *
     * @return bool
     */
    public function isActive();

    /**
     * Determine if the subscription is unpaid.
     *
     * @return bool
     */
    public function isUnpaid();

    /**
     * Determine if the subscription is cancelled.
     *
     * @return bool
     */
    public function isCancelled();

    /**
     * Activate the subscription.
     *
     * @return bool
     */
    public function activate();

    /**
     * Alias for the Activate method.
     *
     * @return bool
     */
    public function renew();

    /**
     * Sets the subscription status to unpaid.
     *
     * @return bool
     */
    public function markAsUnpaid();

    /**
     * Cancel the subscription.
     *
     * @return bool
     */
    public function cancel();
}
