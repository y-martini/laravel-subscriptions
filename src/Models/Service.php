<?php

namespace YuriyMartini\Subscriptions\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use YuriyMartini\Subscriptions\Contracts\Service as ServiceContract;
use YuriyMartini\Subscriptions\Traits\UsesModels;
use YuriyMartini\Subscriptions\Traits\UsesTables;

/**
 * @property string name
 */
class Service extends Model implements ServiceContract
{
    use UsesTables, UsesModels;

    protected $fillable = [
        'key',
        'name',
    ];

    public function getTable()
    {
        return static::getServicesTable();
    }

    /**
     * @return HasMany
     */
    public function plans()
    {
        return $this->hasMany(static::getPlanModel(), 'service_id');
    }
}
