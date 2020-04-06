<?php

namespace YuriyMartini\Subscriptions\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use YuriyMartini\Subscriptions\Contracts\Plan as PlanContract;
use YuriyMartini\Subscriptions\Traits\UsesModels;
use YuriyMartini\Subscriptions\Traits\UsesTables;

/**
 * @property \YuriyMartini\Subscriptions\Contracts\Service service
 * @property string key
 * @property string name
 */
class Plan extends Model implements PlanContract
{
    use UsesTables, UsesModels;

    protected $fillable = [
        'service_id',
        'key',
        'name',
        'price',
        'billing_interval_unit',
        'billing_interval_value',
    ];

    public function getTable()
    {
        return static::getPlansTable();
    }

    /**
     * @return BelongsTo
     */
    public function service()
    {
        return $this->belongsTo(static::getServiceModel(), 'service_id');
    }

    /**
     * @return HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(static::getSubscriptionModel(), 'plan_id');
    }
}
