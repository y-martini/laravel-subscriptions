<?php

namespace YuriyMartini\Subscriptions\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use YuriyMartini\Subscriptions\Contracts\Subscription as SubscriptionContract;
use YuriyMartini\Subscriptions\Traits\UsesModels;
use YuriyMartini\Subscriptions\Traits\UsesTables;

/**
 * @property string status
 * @property \YuriyMartini\Subscriptions\Contracts\Plan plan
 * @property Model user
 */
class Subscription extends Model implements SubscriptionContract
{
    use UsesTables, UsesModels;

    const STATUS_ACTIVE = 'active';
    const STATUS_UNPAID = 'unpaid';
    const STATUS_CANCELLED = 'cancelled';
    const DEFAULT_STATUS = Subscription::STATUS_UNPAID;

    protected $fillable = [
        'user_id',
        'plan_id',
        'status',
        'start_date',
        'end_date',
    ];

    protected $dates = [
        'start_date',
        'end_date',
    ];

    /**
     * @inheritDoc
     */
    public function getTable()
    {
        return static::getSubscriptionsTable();
    }

    protected static function getUserModel()
    {
        return Config::get('subscriptions.users.model');
    }

    /**
     * @inheritDoc
     */
    public function user()
    {
        return $this->belongsTo(static::getUserModel(), 'user_id');
    }

    /**
     * @inheritDoc
     */
    public function plan()
    {
        return $this->belongsTo(static::getPlanModel(), 'plan_id');
    }

    public function ScopeActive(Builder $query)
    {
        return $query->where('status', static::STATUS_ACTIVE);
    }

    /**
     * @inheritDoc
     */
    public function isActive()
    {
        return $this->status === static::STATUS_ACTIVE;
    }

    /**
     * @inheritDoc
     */
    public function isUnpaid()
    {
        return $this->status === static::STATUS_UNPAID;
    }

    /**
     * @inheritDoc
     */
    public function isCancelled()
    {
        return $this->status === static::STATUS_CANCELLED;
    }

    /**
     * @inheritDoc
     */
    public function activate()
    {
        return $this->update(['status' => static::STATUS_ACTIVE]);
    }

    /**
     * @inheritDoc
     */
    public function renew()
    {
        return $this->activate();
    }

    /**
     * @inheritDoc
     */
    public function markAsUnpaid()
    {
        return $this->update(['status' => static::STATUS_UNPAID]);
    }

    /**
     * @inheritDoc
     */
    public function cancel()
    {
        return $this->update(['status' => static::STATUS_CANCELLED]);
    }
}
